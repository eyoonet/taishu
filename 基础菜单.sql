�����滻 P DATA FLOOR MENU��Ҫ�޸�


DELETE FROM think_menu WHERE fid = null


REPLACE INTO `think_menu` (`id`,`title`,`pid`,`fid`,`sort`,`url`,`hide`,`user`) VALUES 
(1,'��ҳ',0,NULL,NULL,'#',NULL,'public'),
(2,'��̨����',0,NULL,NULL,NULL,NULL,'admin'),
(3,'�û�¥����',0,NULL,NULL,NULL,NULL,'public'),
(4,'����ͳ��',0,NULL,NULL,'',NULL,'public'),
(5,'ע��',0,NULL,NULL,'/admin/user/logout',NULL,'public'),
(6,'���¥',2,NULL,NULL,'/admin/floor/add',NULL,'admin'),
(7,'����¥',2,NULL,NULL,'/admin/floor/index',NULL,'admin'),
(8,'����û�',2,NULL,NULL,'/admin/user/add',NULL,'admin'),
(9,'�û��б�',2,NULL,NULL,'/admin/user/index',NULL,'admin'),
(10,'Ĭ����Ŀ����',2,NULL,NULL,'/admin/project/index',NULL,'admin'),
(11,'��ͳ��',4,NULL,NULL,'/admin/total/month',NULL,'public'),
(12,'��ͳ��',4,NULL,NULL,'/admin/total/year',NULL,'public');