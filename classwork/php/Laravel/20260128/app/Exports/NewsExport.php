<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NewsExport implements FromCollection, WithHeadings, WithDrawings, WithEvents
{
    /**
     * 先把資料抓起來存著，drawings() 與 registerEvents() 會用到
     * @var \Illuminate\Support\Collection|null
     */
    private $rows = null;

    public function collection()
    {
        // 這是圖片資料夾的「硬碟路徑」
        $dir = rtrim(public_path('images/news'), '\\/');

        $this->rows = DB::table('news as a')
            ->selectRaw(
                "COALESCE(b.typeName, '') AS typeName,
                 a.title,
                 REPLACE(REPLACE(REPLACE(REPLACE(a.content, '<br />', '\n'), '<br/>', '\n'), '<br>', '\n'), '<br/> ', '\n') AS content,
                 a.photo,
                 a.createTime",
            )
            // ✅ 用 leftJoin：避免有資料 typeId 對不到分類就整筆不出
            ->leftJoin('news_type as b', 'a.typeId', '=', 'b.id')
            ->orderBy('a.createTime', 'desc')
            ->get();

        // ✅ 把 photo 欄位統一加工成「完整硬碟路徑」方便 drawings() 用
        // 你的 DB 建議只存檔名（例如 20260303_121500_xxxxxx.jpg）
        // 但這邊也容錯：若 DB 裡本來就是完整路徑，也能用
        foreach ($this->rows as $row) {
            $p = (string)($row->photo ?? '');

            if ($p === '') {
                $row->photo_full = '';
                continue;
            }

            // 如果 DB 已經存成完整路徑（例如 C:\...\public\images\news\xxx.jpg）
            if (is_file($p)) {
                $row->photo_full = $p;
                continue;
            }

            // 否則當作檔名或相對路徑：組成 public/images/news/檔名
            $row->photo_full = $dir . DIRECTORY_SEPARATOR . ltrim($p, '\\/');
        }

        return $this->rows;
    }

    public function headings(): array
    {
        // 第 4 欄顯示「圖片」；同一欄也會插入圖片
        return ['分類', '標題', '內容', '圖片', '建立時間'];
    }

    /**
     * ✅ 讓圖片真的插進 Excel
     * 每一張圖會插在 D 欄（第 4 欄），從第 2 列開始（第 1 列是表頭）
     */
    public function drawings(): array
    {
        $drawings = [];

        // ✅ 保險：如果 rows 還沒準備好，就先抓資料
        if ($this->rows === null) {
            $this->collection();
        }
        if (!$this->rows) {
            return $drawings;
        }

        foreach ($this->rows as $i => $row) {
            $imgPath = (string)($row->photo_full ?? '');

            // 如果檔案不存在，就跳過，避免匯出噴錯
            if ($imgPath === '' || !is_file($imgPath)) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('photo_' . ($i + 1));
            $drawing->setDescription('News Photo ' . ($i + 1));
            $drawing->setPath($imgPath);

            // 圖片高度（可調）
            $drawing->setHeight(80);

            // D 欄，第 2 列開始（因為第 1 列是 headings）
            $rowNumber = $i + 2;
            $drawing->setCoordinates('D' . $rowNumber);

            // 讓圖片有點內縮，不貼邊
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    /**
     * ✅ 設定欄寬 / 自動換行 / 列高配合圖片
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                // 欄寬（可依喜好調）
                $sheet->getColumnDimension('A')->setWidth(14);
                $sheet->getColumnDimension('B')->setWidth(24);
                $sheet->getColumnDimension('C')->setWidth(50);
                $sheet->getColumnDimension('D')->setWidth(18);
                $sheet->getColumnDimension('E')->setWidth(22);

                // 內容欄自動換行
                $sheet->getStyle('C:C')->getAlignment()->setWrapText(true);

                // ✅ 保險：如果 rows 還沒準備好，就先抓資料
                if ($this->rows === null) {
                    $this->collection();
                }

                // 從第 2 列開始（資料列），每列拉高讓圖片放得下
                if ($this->rows) {
                    $lastRow = count($this->rows) + 1;
                    for ($r = 2; $r <= $lastRow; $r++) {
                        $sheet->getRowDimension($r)->setRowHeight(70);
                    }
                }
            },
        ];
    }
}
