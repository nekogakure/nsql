<?php
class Nsql
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function path($path)
    {
        $this->path = $path;
    }

    public function view()
    {
        return json_decode(file_get_contents($this->path), true);
    }

    public function edit($data)
    {
        $fp = fopen($this->path, 'cb');
        if ($fp) {
            if (flock($fp, LOCK_SH)) {
                if (fwrite($fp, json_encode($data))) {
                    if (flock($fp, LOCK_UN)) {
                        if (fclose($fp)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
?>