<?php

class AdminBaseController extends Controller
{
    
    protected function flash($result)
    {
        if ($result) {
            Notification::success('Record Successfully updated.');
        } else {
            Notification::error("Failed to update record, please try again..");
        }
    }
}
