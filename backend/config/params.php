<?php
return [
    'adminEmail' => 'admin@example.com',
    'gscLayoutModule' => ['consumption', 'gameuser', 'overview', 'pay'],//game servewr channel菜单
    'gcLayoutModule' => ['channel'],//game channel菜单
    'noNeedLogin' => ['/system/site/login', '/system/site/logout', '/system/site/createcode'],
    'retentionDay' => [2, 3, 4, 5, 6, 7, 14, 21, 30],               //计算那些日后的留存率
    'returnEcharts' => 'http://echarts.baidu.com/build/dist',//-加载
    'loseDay' => [7, 14, 30],//流失天数
    'ranks' => [50, 100, 200, 300],//消费排名
    'incomeTop' => [50, 100, 200, 300],//付费排名
    'payContribution' => [7, 14, 30],//-新玩家贡献
    'consumptionType_50' => [
        1 => '强化物品',
        2 => '消耗强化材料卡牌',
        3 => '章节通关奖励',
        4 => '章节满星通关奖励',
        5 => '打怪获得奖励',
        6 => '恢复',
        7 => '过图',
        11 => '副本打怪消耗',
        12 => '获取副本奖励',
        13 => '重置消耗',
        14 => '商店购买',
        15 => '购买[道具获得金币]',
        16 => '购买刷新商店',
        19 => '购买商品',
        20 => '过图获得过关奖励',
        21 => '充值获得金币',
        22 => '出售卡牌',
        23 => '领取邮件奖励',
        24 => '领取成就',
        27 => '升级获得金币',
        28 => '创建公会',
        29 => '捐献军团',
        31 => '开启海天盛宴',
        32 => '开启寻宝',
        34 => '混沌之门白天',
        35 => '购买体力',
        36 => '喵酱の救赎',
        37 => '巨龙宝藏',
        41 => '领取兑换码',
        42 => '填写邀请码',
        43 => '领取邀请奖励',
        44 => '领取活动奖励',
        46 => '首充大礼包',
        47 => '双倍活动钻石',
        48 => '首充获得三倍钻石',
        49 => '出售卡牌',
        52 => '签到奖励',
        53 => '领取VIP福利',
        54 => '开宝箱获得',
        55 => '开宝箱消耗',
        56 => '聚宝盆消耗',
        57 => '聚宝盆获得',
        58 => '获得[城镇资源]',
        59 => '[城镇升级]，消耗',
        60 => '完成[城镇NPC任务]',
        61 => '城镇占卜',
        62 => '城镇巡逻',
        63 => '女仆互动',
        64 => '城镇靈魂歸宿战斗',
        67 => '进化装备',
        68 => '进化卡牌',
        70 => '进化卡牌',
        71 => '加入国家',
        72 => '国战鼓舞',
        73 => '国战秒CD',
        74 => '国战召唤神兽',
        75 => '国战获得',
        76 => '资源抢夺钻石领取-消耗',
        77 => '资源抢夺钻石领取-获得',
        78 => '资源抢夺',
        79 => 'BOSS战复活',
        80 => '洗练',
        81 => '资源抢夺',
        82 => '购买女仆',
        83 => '领取占卜星座',
        84 => '女仆互动',
        85 => '女仆赠送',
        86 => '许愿池许愿',
        87 => '许愿池领奖',
        88 => '全民月卡',
        89 => '全民投资',
        90 => '参加海天盛筵',
        91 => '豪华签到',
        92 => '使用道具',
        93 => '完成任务',
        94 => '开服七天',
        95 => '巴别塔',
        98 => '限时兑换',
        99 => '购买终身礼包',
        100 => '炼化',
        101 => '十连抽',
        102 => '抽奖',
        103 => '完成每日任务',
        104 => '升级必杀技',
        105 => '穿时装',
        107 => '出售物品',
        108 => '碎片合成',
        109 => '天赋升星',
        110 => '拾取玉',
        111 => '出售玉',
        112 => '卡牌重生',
        113 => '七天连续登录奖励',
        114 => '充值礼包获得',
        115 => '等级礼包获得',
        116 => '吃鸡腿获得',
        117 => '购买精英副本次数',
        118 => '购买VIP礼包',
        119 => '领取在线奖励',
        120 => '扫荡关卡',
        121 => '挑战竞技场',
        122 => '购买竞技场挑战',
        123 => '强化物品',
        124 => '[抽奖]获得',
        125 => '寻玉',
        126 => '一键寻玉',
        127 => '精灵培养 消耗',
        128 => '精灵培养',
        129 => '夺宝',
        130 => '夺宝换一批',
        131 => '必杀技重置',
        132 => '寻玉购买4号',
        133 => '领取好友体力',
        134 => '水晶强化',
        135 => '补签',
        136 => '补签-获得',
        137 => '大逆转副本',
        138 => '活动副本',
        139 => '购买制霸次数',
        140 => '购买抢夺次数',
        141 => '大冒险开宝箱',
        142 => '大冒险打怪',
        143 => '限时礼包',
        144 => '领取投资礼包',
        145 => '领取血战到底',
        146 => '神秘商店刷新',
        147 => '大转盘',
        148 => '点赞',
        149 => '公会BOSS',
        150 => '灵珠培养',
        151 => '进化',
        152 => '转职',
        153 => '领取七日限时奖励',
        154 => '万能碎片兑换卡牌',
        155 => '升级宝箱',
        156 => '领取任务奖励',
        157 => '巴别塔扫荡',
        158 => '欧皇领取卡牌',
        159 => '欧皇领取星钻',
        160 => '月卡每日领取星钻',

    ],
    'consumptionType_70' => [
        1=>'默认',
        2=>'GM命令',
        3=>'创建新角色',
        4=>'卖物品',
        5=>'铜钱招募',
        6=>'钻石招募',
        7=>'远征',
        8=>'副本',
        9=>'合成物品',
        10=>'使用物品',
        11=>'商店购买',
        12=>'好友精力',
        13=>'运营活动',
        14=>'回收',
        15=>'任务',
        16=>'章节宝箱',
        17=>'邮件',
        18=>'竞技场',
        19=>'签到',
        20=>'卖装备',
        21=>'充值商店',
        22=>'叛军',
        23=>'成就',
        24=>'军团',
        25=>'军团祭祀',
        26=>'讨伐',
        27=>'月卡',
        28=>'在线礼包',
        29=>'任务积分',
        30=>'充值',
        31=>'公告',
        32=>'升星',
        33=>'神转',
        34=>'夺宝',
        35=>'七日活动',
        36=>'半价购买',
        41=>'商店1',
        42=>'商店2',
        43=>'商店3',
        44=>'商店4',
        45=>'商店5',
        46=>'商店6',
        47=>'商店7',
        48=>'商店8',
        49=>'商店9',
        50=>'商店10',
        60=>'商店20',
        61=>'军团领地',
        62=>'官职',
        999=>'增加物品来源最大值',
        1000=>'默认(消耗物品)',
        1001=>'天赋强化',
        1002=>'铜钱招募',
        1003=>'钻石招募',
        1004=>'改名字',
        1005=>'改头像',
        1006=>'购买技能点',
        1007=>'卖物品',
        1008=>'副本',
        1009=>'合成物品',
        1010=>'使用物品',
        1011=>'重置副本次数',
        1012=>'武将升星',
        1013=>'武将加经验',
        1014=>'武将强化',
        1015=>'武将天赋强化',
        1016=>'装备强化',
        1017=>'装备精炼',
        1018=>'商店购买',
        1019=>'商店刷新',
        1020=>'竞技场',
        1021=>'运营活动',
        1022=>'回收',
        1023=>'充值商店',
        1024=>'叛军',
        1025=>'军团',
        1026=>'军团祭祀',
        1027=>'购买副本次数',
        1028=>'夺宝',
        1029=>'购买次数',
        1030=>'官职',
        1031=>'讨伐',
        1032=>'半价购买'
    ],
];
