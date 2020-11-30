<?php
/**
 * excel类集合
 * Created by PhpStorm.
 * User: 10574
 * Date: 2017/9/25
 * Time: 9:22
 */

namespace App\Service;

class ExcelService
{

    /**
     * 获取excel数据
     * @param string $file_name
     * author chengcong
     */
    public static function getExcelData($fileName, $extension = '')
    {
        // 引入包含excel工具类
        require_once(app_path('Util/PHPExcel.php'));
        require_once(app_path('Util/PHPExcel/Writer/Excel2007.php'));
        require_once(app_path('Util/PHPExcel/Style/Fill.php'));

        $data = [];
        if (!is_file($fileName)) return $data;

        //实例化PHPExcel对象
        if ($extension == 'xlsx') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        } else {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fileName);

        // 读取excel文件中的第一个工作表
        $objWorksheet = $objPHPExcel->getSheet(0);
        //取得excel的总行数
        $highestRow = $objWorksheet->getHighestRow();
        //取得excel的总列数
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

        for ($row = 2; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $data[$row - 2][] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }

        return $data;
    }

    /**
     * 导入excle
     * @param $excelData
     * author chengcong
     */
    public static function makeExcel($fileName, $headArr, $data)
    {
        // 引入包含excel工具类
        require_once(app_path('Util/PHPExcel.php'));
        require_once(app_path('Util/PHPExcel/Writer/Excel5.php'));
        require_once(app_path('Util/PHPExcel/IOFactory.php'));

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();

        //设置表头
        $key = ord("A");
        $h   = 1;
        foreach ($headArr as $v) {
            if (!is_array($v)) {
                $colum = chr($key);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
                $key += 1;
            } else {
                $key = ord("A");
                foreach ($v as $val) {
                    $colum = chr($key);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . $h, $val);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . $h, $val);
                    $key += 1;
                }
                $h += 1;
            }
        }

        $column      = $h > 1 ? 3 : 2; // 3-两行头信息，2-一行头信息
        $objActSheet = $objPHPExcel->getActiveSheet();
        //print_r($data);exit;
        foreach ($data as $key => $rows) { //行写入
            $span = ord("A");
            foreach ($rows as $value) {// 列写入
                $j = chr($span);
                if ($j == 'B') { // 设置单元格为文本
                    $objActSheet->setCellValueExplicit('B' . $column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $objActSheet->getStyle('B' . $column)->getNumberFormat()->setFormatCode("@");
                } else {
                    $objActSheet->setCellValue($j . $column, $value);
                }
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }


}