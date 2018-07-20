<?php
/**
 * 组织：[namespace]
 * 项目名称:[name]
 * 分支名称：[branch]
 */
return [
    'chinaphpcoder' => [
        'tools' => [
            '*' => [
                'nohup /bin/sh '.env('AUTO_DEPLOY_PATH').'/tools.sh [branch] > /dev/null 2>&1 &',
            ],
        ],
    ],
];
