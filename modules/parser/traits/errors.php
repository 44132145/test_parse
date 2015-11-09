<?php
trait errors
{
    private $errors = [];
    private $defaultError = [
                                'code' => 501,
                                'text' => 'System error'
    ];

    public function GetLastError()
    {
        if (!empty($this->errors))
            return current($this->errors);
        else
            return [];
    }

    public function GetAllErrors()
    {
        return $this->errors;
    }

    protected function SetError($code = 0, $text = '')
    {
        $this->errors = array_merge($this->errors, [
                            'code' => ((intval($code) > 0)? $code: $this->defaultError['code']),
                            'text' => ((strlen($text) > 0)? $text:$this->defaultError['text'])
        ]);

        return true;
    }
}
?>