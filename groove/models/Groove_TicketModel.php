<?php
namespace Craft;

class Groove_TicketModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'message' => array(AttributeType::String, 'required' => true, 'default' => ''),
            'email' => array(AttributeType::String, 'required' => true, 'default' => ''),
            'to' => array(AttributeType::String, 'required' => false, 'default' => ''),
        );
    }
}