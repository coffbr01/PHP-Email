<?php
class MimeType {
    var $dict;

    function MimeType() {
        $this->dict = array(
            "bin" => "application/octet-stream",
            "bmp" => "image/bmp",
            "doc" => "application/msword",
            "docx" => "application/msword",
            "gif" => "image/gif",
            "gtar" => "application/x-gtar",
            "gz" => "application/x-gzip",
            "gzip" => "application/x-gzip",
            "htm" => "text/html",
            "html" => "text/html",
            "jara" => "application/jar-archive",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "pdf" => "application/pdf",
            "png" => "image/png",
            "pot" => "application/mspowerpoint",
            "pps" => "application/mspowerpoint",
            "ppt" => "application/mspowerpoint",
            "pptx" => "application/mspowerpoint",
            "rtf" => "application/rtf",
            "tar" => "application/x-tar",
            "w6w" => "application/msword",
            "word" => "application/msword",
            "xla" => "application/msexcel",
            "xls" => "application/msexcel",
            "xlt" => "application/msexcel",
            "xlw" => "application/msexcel",
            "xlsx" => "application/msexcel",
            "zip" => "application/zip"
        );
    }

    function getMimeType($filename) {
        $path_info = pathinfo($filename);
        $extension = $path_info["extension"];
        return $this->dict[$extension];
    }
}

