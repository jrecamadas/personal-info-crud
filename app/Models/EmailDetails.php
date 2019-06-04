<?php

namespace App\Models;

use \Blade;

/**
 * Use for email sending
 */
class EmailDetails extends BaseModel
{
    private $recipients = array();
    private $emailTemplate = null;
    private $emailData = array();

    public function getToAttribute()
    {
        return $this->recipients;
    }

    private function render($__php, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw new \FatalThrowableError($e);
        }
        return ob_get_clean();
    }

    public function getSubjectAttribute()
    {
        $subjectStr = $this->emailTemplate->subject;
        $subjectStr = str_replace('❴', '{', $subjectStr);
        $subjectStr = str_replace('❵', '}', $subjectStr);

        return $this->render(Blade::compileString($subjectStr), $this->emailData);
    }

    public function getBodyAttribute()
    {
        $bodyStr = $this->emailTemplate->body;
        $bodyStr = str_replace('❴', '{', $bodyStr);
        $bodyStr = str_replace('❵', '}', $bodyStr);

        return $this->render(Blade::compileString($bodyStr), $this->emailData);
    }

    public function setTemplateAttribute(EmailTemplate $value)
    {
        $this->emailTemplate = $value;
    }

    public function addTo($email)
    {
        $this->recipients[] = $email;
    }

    public function addData($key, $value)
    {
        $this->emailData[$key] = $value;
    }
}
