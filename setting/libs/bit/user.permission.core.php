<?php
namespace PHPEasy\Cores;
class _Permission extends _Bit{
    const Read = 1;
    const Write = 2;
    const Delete = 4;
    const Update = 8;
    const Edit = 16;
    // const All = 15;
}
?>