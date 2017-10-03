<?php
namespace PHPEasy\Cores;
class _StoreProcedure extends _Database{
    const Permission = "SELECT * 
                        FROM   (SELECT `GroupUserPermission`.`FunctionId`      AS `FunctionId`, 
                                      `GroupUserPermission`.`UserId`          AS `UserId`, 
                                      MAX(`GroupUserPermission`.`Permission`) AS `Permission` 
                                FROM   (SELECT `f`.`FunctionId` AS `FunctionId`, 
                                              `c`.`GroupId`    AS `GroupId`, 
                                              `a`.`UserId`     AS `UserId`, 
                                              SUM(`d`.`Value`) AS `Permission` 
                                        FROM   `User` `a` 
                                              JOIN `UserInGroup` `b` 
                                                ON ( `a`.`UserId` = `b`.`UserId` ) 
                                              JOIN `Group` `c` 
                                                ON ( `b`.`GroupId` = `c`.`GroupId` ) 
                                              JOIN `ACL` `d` 
                                                ON ( `c`.`GroupId` = `d`.`GroupId` ) 
                                              JOIN `Object` `e` 
                                                ON ( `d`.`ObjectId` = `e`.`ObjectId` 
                                                      AND `e`.`TableName` = 'Function' ) 
                                              JOIN `Function` `f` 
                                                ON ( `e`.`PrimaryKey` = `f`.`FunctionId` ) 
                                        GROUP  BY `f`.`FunctionId`, 
                                                  `c`.`GroupId`, 
                                                  `a`.`UserId`)GroupUserPermission 
                                GROUP  BY `GroupUserPermission`.`UserId`, 
                                          `GroupUserPermission`.`FunctionId`)Permission 
    ";
}