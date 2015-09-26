<?php
namespace Craft;

class GrooveVariable
{
    public function getMailboxes()
    {
        return craft()->groove->getMailboxes();
    }
}