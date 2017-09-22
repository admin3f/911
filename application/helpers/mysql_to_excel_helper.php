<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/*
* Excel library for Code Igniter applications
* Author: Derek Allard
*/
 
function to_excel($fields, $filename='exceloutput')
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
          
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;Filename=\"".$filename.".xls\"");
//    header("Content-Disposition: attachment; Filename={$filename}.xls");

          foreach ($fields[0] as $field => $name) {
             $headers .= $field . "\t";
          }
           echo mb_convert_encoding("$headers\n",'utf-16','utf-8');

          foreach ($fields as $row) {
               $line = '';
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
//               $data .= trim($line)."\n";
               $line = trim($line)."\n";
               echo mb_convert_encoding(Str_replace("\r","",$line),'utf-16','utf-8');
          }
//          echo mb_convert_encoding(Str_replace("\r","",$data),'utf-16','utf-8');
     }

//function to_excel($fields, $filename='exceloutput')
//{
//     $headers = ''; // just creating the var for field headers to append to below
//     $data = ''; // just creating the var for field data to append to below
// 
//
//          foreach ($fields[0] as $field => $name) {
//             $headers .= $field . "\t";
//          }
// 
//          foreach ($fields as $row) {
//               $line = '';
//               foreach($row as $value) {                                            
//                    if ((!isset($value)) OR ($value == "")) {
//                         $value = "\t";
//                    } else {
//                         $value = str_replace('"', '""', $value);
//                         $value = '"' . $value . '"' . "\t";
//                    }
//                    $line .= $value;
//               }
//               $data .= trim($line)."\n";
//          }
// 
//          $data = str_replace("\r","",$data);
// 
//          header("Content-type: application/x-msdownload");
//          header("Content-Disposition: attachment; filename=$filename.xls");
//          echo mb_convert_encoding("$headers\n$data",'utf-16','utf-8');
//     }

?>