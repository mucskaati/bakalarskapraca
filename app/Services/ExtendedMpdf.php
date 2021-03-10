<?php

namespace App\Services;

class ExtendedMpdf extends \Mpdf\Mpdf
{
    public function GetFullPath(&$path, $basepath = '')
    {
        // When parsing CSS need to pass temporary basepath - so links are relative to current stylesheet
        if (!$basepath) {
            $basepath = $this->basepath;
        }

        // Fix path value
        $path = str_replace("\\", '/', $path); // If on Windows

        // mPDF 5.7.2
        if (substr($path, 0, 2) === '//') {
            $scheme = parse_url($basepath, PHP_URL_SCHEME);
            $scheme = $scheme ?: 'http';
            $path = $scheme . ':' . $path;
        }

        $path = preg_replace('|^./|', '', $path); // Inadvertently corrects "./path/etc" and "//www.domain.com/etc"

        if (substr($path, 0, 1) == '#') {
            return;
        }

        if (preg_match('@^(mailto|tel|fax):.*@i', $path)) {
            return;
        }

        if (substr($path, 0, 3) == "../") { // It is a relative link

            $backtrackamount = substr_count($path, "../");
            $maxbacktrack = substr_count($basepath, "/") - 3;
            $filepath = str_replace("../", '', $path);
            $path = $basepath;

            // If it is an invalid relative link, then make it go to directory root
            if ($backtrackamount > $maxbacktrack) {
                $backtrackamount = $maxbacktrack;
            }

            // Backtrack some directories
            for ($i = 0; $i < $backtrackamount + 1; $i++) {
                $path = substr($path, 0, strrpos($path, "/"));
            }

            $path = $path . "/" . $filepath; // Make it an absolute path

        } else { // It is a local link

            if (substr($path, 0, 1) == "/") {

                $tr = parse_url($basepath);

                // mPDF 5.7.2
                $root = '';
                if (!empty($tr['scheme'])) {
                    $root .= $tr['scheme'] . '://';
                }

                $root .= isset($tr['host']) ? $tr['host'] : '';
                $root .= ((isset($tr['port']) && $tr['port']) ? (':' . $tr['port']) : ''); // mPDF 5.7.3

                $path = $root . $path;
            } else {
                $path = $basepath . $path;
            }
        }
        // Do nothing if it is an Absolute Link
    }
}
