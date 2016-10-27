<?php

namespace application\models;

use core\auth\Authenticated;
use core\models\ModelDb;

class MemberIpsModel extends ModelDb
{
    public function getTableName()
    {
        return 'member_ips';
    }
}