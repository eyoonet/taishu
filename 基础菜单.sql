复制替换 P DATA FLOOR MENU需要修改


DELETE FROM think_menu WHERE fid = null


REPLACE INTO `think_menu` (`id`,`title`,`pid`,`fid`,`sort`,`url`,`hide`,`user`) VALUES 
(1,'首页',0,NULL,NULL,'#',NULL,'public'),
(2,'后台管理',0,NULL,NULL,NULL,NULL,'admin'),
(3,'用户楼管理',0,NULL,NULL,NULL,NULL,'public'),
(4,'数据统计',0,NULL,NULL,'',NULL,'public'),
(5,'注销',0,NULL,NULL,'/admin/user/logout',NULL,'public'),
(6,'添加楼',2,NULL,NULL,'/admin/floor/add',NULL,'admin'),
(7,'管理楼',2,NULL,NULL,'/admin/floor/index',NULL,'admin'),
(8,'添加用户',2,NULL,NULL,'/admin/user/add',NULL,'admin'),
(9,'用户列表',2,NULL,NULL,'/admin/user/index',NULL,'admin'),
(10,'默认项目设置',2,NULL,NULL,'/admin/project/index',NULL,'admin'),
(11,'月统计',4,NULL,NULL,'/admin/total/month',NULL,'public'),
(12,'年统计',4,NULL,NULL,'/admin/total/year',NULL,'public');