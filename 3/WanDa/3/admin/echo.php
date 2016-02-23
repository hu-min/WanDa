<?php
$type = $_GET["type"];
switch ($type) {
    case "Task":
        Task();
        break;
    case "sign":
        sign();
        break;
    default:
        ;
        break;
}

function Task()
{
    ;
}

function sign()
{
    $str = '[
    {id:"001",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"警告",times:"标记此员工（累计请假12天 ）"},
    {id:"002",beizhu:"很高心省办了",name:"小李",sign:"请假",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    {id:"003",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"警告",times:"标记此员工（累计请假9天 ）"},
    {id:"004",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    {id:"005",beizhu:"很高心省办了",name:"小李",sign:"请假",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    {id:"006",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"警告",times:"标记此员工（累计请假10天 ）"},
    {id:"007",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    {id:"008",beizhu:"很高心省办了",name:"小李",sign:"请假",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    {id:"009",beizhu:"很高心省办了",name:"小李",sign:"签到",date:"2015-09-09 15:05",warring:"警告",times:"标记此员工（累计请假16天 ）"},
    {id:"010",beizhu:"很高心省办了",name:"小李",sign:"请假",date:"2015-09-09 15:05",warring:"正常",times:"累计请假2天"},
    ]';
    echo $str;
}
?>