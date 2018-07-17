<?php
/**
 * 组织：[namespace]
 * 项目名称:[name]
 * 分支名称：[branch]
 */
return [
    'sxsmanon' => [
        'sxs-api' => [
            '*' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-app.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-h5.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-pc.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-h5-m1.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-pc-w1.sh [branch] > /dev/null 2>&1 &"
            ],
            'feature/h5_xinshou_two' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-h5.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-xinshou-ym.sh [branch] > /dev/null 2>&1 &"
            ],
            'feature/p2peye' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-cyx.sh [branch] > /dev/null 2>&1 &",
            ],

            'feature/new_sanbiao' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-cyx.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api-h5.sh [branch] > /dev/null 2>&1 &",
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-api.sh [branch] > /dev/null 2>&1 &",
            ],

        ],
        'sxs-vault' => [
            '*' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-vault.sh [branch] > /dev/null 2>&1 &",
            ],
        ],
        'sxs-official-api' => [
            '*' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-official-api.sh [branch] > /dev/null 2>&1 &"
            ],
        ],
        'sxs-official-cms' => [
            '*' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-official-cms.sh [branch] > /dev/null 2>&1 &"
            ],
        ],
        'sxs-h5' => [
            '*' => [
                //"nohup /bin/sh /home/test/local/works/auto_deploy/sxs-h5.sh [branch] > /dev/null 2>&1 &"
            ],
        ],
        'sxs-official' => [
            '*' => [
                //"nohup /bin/sh /home/test/local/works/auto_deploy/sxs-official.sh [branch] > /dev/null 2>&1 &"
            ],
        ],    
    ],
    'sxsphp' => [
        'sxs-tools' => [
            '*' => [
                "nohup /bin/sh /home/test/local/works/auto_deploy/sxs-tools.sh [branch] > /dev/null 2>&1 &"
            ],
        ],
    ],
];
