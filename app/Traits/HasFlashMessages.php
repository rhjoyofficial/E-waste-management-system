<?php

namespace App\Traits;

trait HasFlashMessages
{
    /**
     * Flash a success message
     */
    protected function flashSuccess($message)
    {
        session()->flash('success', $message);
        $this->flashToSystem($message, 'success');
    }

    /**
     * Flash an error message
     */
    protected function flashError($message)
    {
        session()->flash('error', $message);
        $this->flashToSystem($message, 'error');
    }

    /**
     * Flash a warning message
     */
    protected function flashWarning($message)
    {
        session()->flash('warning', $message);
        $this->flashToSystem($message, 'warning');
    }

    /**
     * Flash an info message
     */
    protected function flashInfo($message)
    {
        session()->flash('info', $message);
        $this->flashToSystem($message, 'info');
    }

    /**
     * Flash to the JavaScript system
     */
    private function flashToSystem($message, $type = 'success', $duration = 5000, $description = null)
    {
        session()->flash('flash_message', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
            'description' => $description
        ]);
    }
}
