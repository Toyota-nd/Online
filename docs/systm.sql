USE `toyota`;

/*VIEW----Only execute them one by one ----------------------*/
DELIMITER $$
/*Step 1*/
CREATE OR REPLACE VIEW `squestions` AS 
select `questions`.`questions_id` AS `questions_id`,
`questions`.`name` AS `name`,
`questions`.`supervisor` AS `supervisor`,
`questions`.`exampaper_id` AS `exampaper_id`,
`toyota`.`questions`.`myorder` AS `myorder`,
`toyota`.`questions`.`question_id` AS `question_id`,
`toyota`.`questions`.`singleans` AS `singleans`,
`toyota`.`questions`.`subject` AS `subject`,
`toyota`.`questions`.`uncertainty` AS `uncertainty`,
`toyota`.`questions`.`url` AS `url`,
`toyota`.`questions`.`description` AS `description`,
`toyota`.`questions`.`mytype` AS `mytype` 
from `questions` 
where ((`toyota`.`questions`.`mytype` = 'radio') 
and (`toyota`.`questions`.`singleans` > 0));

/*Step 2*/
CREATE OR REPLACE VIEW `mquestions` AS
select `questions`.`exampaper_id` AS `exampaper_id`,
`questions`.`questions_id` AS `questions_id`,
`questions`.`question_id` AS `question_id`,
`answers`.`multians` AS `multians`,
`answers`.`myorder` AS `myorder`
from (`questions`
join `answers` on
((`questions`.`questions_id` = `answers`.`questions_id`)))
where (`questions`.`mytype` = 'checkbox');

/*Step 3*/
CREATE OR REPLACE VIEW `squestion` AS
select `question`.`question_id` AS `question_id`,
`question`.`name` AS `name`,`question`.`supervisor` AS `supervisor`,
`question`.`url` AS `url`,`toyota`.`question`.`myorder` AS `myorder`,
`toyota`.`question`.`partition_id` AS `partition_id`,
`toyota`.`question`.`exam_id` AS `exam_id`,
`toyota`.`question`.`description` AS `description`,
`toyota`.`question`.`mytype` AS `mytype`,
`toyota`.`question`.`singleans` AS `singleans`,
`toyota`.`question`.`subject` AS `subject`,
`toyota`.`question`.`uncertainty` AS `uncertainty`
from `question`
where ((`toyota`.`question`.`mytype` = 'radio')
and (`toyota`.`question`.`singleans` > 0));

/*Step 4*/
CREATE OR REPLACE VIEW `mquestion` AS
select `question`.`question_id` AS `question_id`,
`toyota`.`question`.`mytype` AS `mytype`,
`toyota`.`answer`.`multians` AS `multians`,
`toyota`.`answer`.`myorder` AS `myorder`
from (`question` join `answer` on
((`toyota`.`question`.`question_id` = `toyota`.`answer`.`question_id`)))
where (`toyota`.`question`.`mytype` = 'checkbox');

/*Step 5*/
CREATE OR REPLACE VIEW `single_question` AS
select `questions`.`exampaper_id` AS `exampaper_id`,
((`exampaper`.`single` * sum((`question`.`singleans` = `questions`.`singleans`))) /
 count((`question`.`singleans` = `questions`.`singleans`))) AS `ans`,
 `question`.`mytype` AS `mytype`
 from ((`squestion` `question`
 join `squestions` `questions` on
 ((`question`.`question_id` = `questions`.`question_id`)))
 join `exampaper` on
 ((`questions`.`exampaper_id` = `exampaper`.`exampaper_id`)))
 group by `questions`.`exampaper_id`,
 `question`.`mytype`,`exampaper`.`multiple`;

 
/*Step 6*/
CREATE OR REPLACE VIEW `multiple_question` AS
 select `questions`.`exampaper_id` AS `exampaper_id`,
 `question`.`mytype` AS `mytype`,
 (sum((`question`.`multians` = `questions`.`multians`)) = 
 max(`questions`.`myorder`)) AS `ans`,
 `toyota`.`exampaper`.`multiple` AS `multiple`
 from ((`mquestion` `question` join `mquestions` `questions` on
 (((`question`.`question_id` = `questions`.`question_id`) and
 (`question`.`myorder` = `questions`.`myorder`))))
 join `exampaper` on
 ((`questions`.`exampaper_id` = `toyota`.`exampaper`.`exampaper_id`)))
 group by `questions`.`exampaper_id`,
 `questions`.`questions_id`,
 `question`.`question_id`,
 `question`.`mytype`,
 `toyota`.`exampaper`.`multiple`;

/*Step 7*/
CREATE OR REPLACE VIEW `multiple_questions` AS
select `mark1`.`exampaper_id` AS `exampaper_id`,
((`mark1`.`multiple` * sum(`mark1`.`ans`)) /
count(`mark1`.`ans`)) AS `multiple*sum(ans)/count(ans)`,
`mark1`.`mytype` AS `mytype`
from `multiple_question` `mark1` 
group by `mark1`.`exampaper_id`;

/*Step 8*/
CREATE OR REPLACE VIEW `myscore`AS
select `single_question`.`exampaper_id` AS `exampaper_id`,
`single_question`.`ans` AS `ans`,
`single_question`.`mytype` AS `mytype`
from `single_question`
union all
select `multiple_questions`.`exampaper_id` AS `exampaper_id`,
`multiple_questions`.`multiple*sum(ans)/count(ans)` AS `multiple*sum(ans)/count(ans)`,
`multiple_questions`.`mytype` AS `mytype`
 from `multiple_questions`;


/*Step 9*/
CREATE OR REPLACE VIEW `examscore` AS
select `myscore`.`exampaper_id` AS `exampaper_id`,
round(sum(`myscore`.`ans`),0) AS `score` 
from `myscore`
group by `myscore`.`exampaper_id`;
/*-------------------------*/
/*Step 10*/
CREATE OR REPLACE VIEW `examinfo` AS
select `exampaper`.`exampaper_id` AS `examinfo_id`,
`user`.`user_id` AS `user_id`,
`user`.`name` AS `user_name`,`exampaper`.
`name` AS `exampaper_name`,`questions`.
`name` AS `questions_name`,
`task`.`name` AS `task_name`,
`department`.`name` AS `department_name`,
`role`.`name` AS `role_name`
from (((((`exampaper` join `user` on((`user`.`user_id` = `exampaper`.`user_id`)))
join `questions` on
((`exampaper`.`exampaper_id` = `questions`.`exampaper_id`)))
 join `task` on((`user`.`user_id` = `task`.`user_id`)))
 join `department` on((`task`.`department_id` = `department`.`department_id`)))
 join `role` on((`role`.`role_id` = `task`.`role_id`)))
 where (`questions`.`supervisor` = 0);
 
CREATE OR REPLACE VIEW `examscore` AS
SELECT ep.exampaper_id, q.question_id, u.user_id, d.name as d_name, ep.name as ep_name, p.name as p_name, q.name as q_name,
q.description, p.score as p_score, p.item, e.single, q.singleans as q_singleans, qs.singleans as qs_singleans,
p.score/p.item * (q.singleans = qs.singleans) as score
FROM question q
join questions qs on q.question_id = qs.question_id
join partition p on p.partition_id = q.partition_id
join exam e on e.exam_id = p.exam_id
join exampaper ep on e.exam_id = ep.exam_id
join department d on d.department_id = ep.department_id
join user u on u.user_id = ep.user_id
where q.mytype is not null
order by qs.exampaper_id, q.partition_id

CREATE OR REPLACE VIEW `exampart` AS
SELECT exampaper_id, user_id, d_name, ep_name, p_name as name, 
max(score) as maxscore,
min(score) as minscore,
avg(score) as avgscore
FROM examscore e group by exampaper_id, p_name order by exampaper_id;

CREATE OR REPLACE VIEW `examall` AS
SELECT exampaper_id, user_id, d_name, ep_name, p_name as name, 
max(score) as maxscore,
min(score) as minscore,
sum(score) as sumscore,
avg(score) as avgscore
FROM examscore e group by exampaper_id order by user_id;

CREATE OR REPLACE VIEW `portfolioscore` AS
SELECT task_id as task_id,
t.name as task_name,
exampaper_id,
e.user_id, 
d_name as department,
ep_name as exampaper,
e.name as partition, 
sumscore
FROM task t join examall e on t.user_id = e.user_id;

CREATE OR REPLACE VIEW `acl` AS
SELECT  r.role_id role_id, g.name mygroup,g.mytype mytype,
r.name role, m.name control,m.module module,
p.name action, p.allow allow FROM privilege p  join myresource m
on m.myresource_id = p.myresource_id
join role r
on r.role_id = p.role_id
join mygroup g
on g.mygroup_id = r.mygroup_id
/*PROCEDURE----------------------------------------------------*/
DELIMITER $$
DROP PROCEDURE IF EXISTS `randpicker` $$
CREATE PROCEDURE randpicker(In examid INT(10), OUT questions_count INT)
root:BEGIN
/*
CALL randpicker(2, @questions_count);
SELECT @questions_count;
*/
DECLARE part VARCHAR(45);
DECLARE part_id INT;
DECLARE limits INT;
DECLARE offsets INT;
DECLARE total_offsets INT;
DECLARE max_id INT;
DECLARE root_question_id INT;
DECLARE no_more_departments INT;
DECLARE mymark INT;

DECLARE question_id INT;
DECLARE supervisor INT;

DECLARE partition_csr CURSOR FOR
	select q.supervisor as supervisor, p.item as limits, 
	count(*) as offsets,qq.name, p.partition_id
	from que q
	join que qq on qq.que_id = q.supervisor
	join partition p on p.name = qq.name
	where p.exam_id = examid
	group by qq.name;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_more_departments=1;
	SET no_more_departments=0;
	SET @total_offsets=0;
	SET @questions_count=0;
	START TRANSACTION;
	
	SET @examid = examid; 
    PREPARE STMT FROM 
	"select mark into @mymark from exam where exam_id = ?";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;
	IF NOT (@mymark = 0 OR @mymark = 9) THEN
		SET @questions_count = 0;
		LEAVE root;
	END IF;
	
	SET @examid = examid; 
    PREPARE STMT FROM 
	"delete from question where exam_id = ?";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;

	SET @examid = examid; 
    SET @root_question_id = 1;
    PREPARE STMT FROM 
	"insert into question (question_id,name,supervisor,exam_id)
		SELECT ? as question_id, 
		name, 0 as supervisor, ? as exam_id
		FROM exam where exam_id = ?";
	EXECUTE STMT USING @root_question_id, @examid, @examid;
	DEALLOCATE PREPARE STMT;

	OPEN partition_csr;
	dept_loop:WHILE(no_more_departments=0) DO
		FETCH partition_csr INTO supervisor,limits,offsets,part,part_id;

		IF no_more_departments=1 THEN
			LEAVE dept_loop;
		END IF;
		/* Question table for question label*/
		SET @part = part;
		SET @supervisor = supervisor;
			PREPARE STMT FROM 
		"insert into question (question_id,name,supervisor,exam_id) 
		values (?,?,?,?)";
		EXECUTE STMT USING @supervisor, @part, @root_question_id,@examid;
		DEALLOCATE PREPARE STMT;

		/* Question table for question*/
		SET @examid = examid; 
		SET @limits = limits; 
		SET @part_id = part_id;
		PREPARE STMT FROM 
		"insert into question (question_id,name,supervisor,exam_id,partition_name,partition_id, mytype, url, description, singleans)
		select que_id,qs.name,? as supervisor,? as exam_id,partition_name,? as partition_id, mytype, url, description, singleans  from
		(select q.que_id,
		q.name as name, qq.name as partition_name, q.mytype, q.url, q.description, q.singleans
		from que as q
		join que qq  on qq.que_id = q.supervisor
		order by rand())  as qs
		join
		(select name from partition where exam_id = ?) as p
		on qs.partition_name = p.name
			order by partition_name
		limit ?,?";
		EXECUTE STMT USING @supervisor, @examid, @part_id, @examid, @total_offsets, @limits;
		DEALLOCATE PREPARE STMT;

		SET @total_offsets = @total_offsets + offsets;
		SET @questions_count = @questions_count + limits;

	END WHILE dept_loop;

	/* Remove question no*/	
	/*
	SET @examid = examid; 
    PREPARE STMT FROM 
	"update question set name = regex_replace('^[0-9]+','',name) 
	where exam_id = ? and name REGEXP '^[0-9]+\. and mytype is not null';
	";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;
	*/
	/* Add new question no*/	
    PREPARE STMT FROM 
	"update question q join (select concat(rowid, name) as name,question_id from (select @rowid := @rowid + 1 as rowid,question_id, name
	from question,(select @rowid :=0) as init where exam_id = ? and mytype is not null order by supervisor) as que) as quest
	on q.question_id = quest.question_id
	set q.name = quest.name
	where q.exam_id = ? and q.mytype is not null
	";
	EXECUTE STMT USING @examid,@examid;
	DEALLOCATE PREPARE STMT;	
	/* Answer table*/
    PREPARE STMT FROM 
	"insert into answer select
	ans_id as answer_id,
	ans.name as name,
	que_id as question_id,
	multians,
	ans.myorder as myorder,
	ans.description as description,
	?
	from (SELECT * FROM `question` where question.exam_id = ?) as que
	join ans
	on que.question_id = ans.que_id";
	EXECUTE STMT USING @examid,@examid;
	DEALLOCATE PREPARE STMT;
	COMMIT;
	CLOSE partition_csr;
	SET no_more_departments=0; 
END $$
DELIMITER ;


/*PROCEDURE----------------------------------------------------*/
DELIMITER $$
DROP PROCEDURE IF EXISTS `randpicker1` $$
CREATE PROCEDURE randpicker1(In examid INT(10), OUT questions_count INT)
BEGIN
/*
CALL randpicker(2, @questions_count);
SELECT @questions_count;
*/
DECLARE part VARCHAR(45);
DECLARE part_id INT;
DECLARE limits INT;
DECLARE offsets INT;
DECLARE total_offsets INT;
DECLARE max_id INT;
DECLARE root_question_id INT;
DECLARE no_more_departments INT;

DECLARE question_id INT;
DECLARE supervisor INT;

DECLARE partition_csr CURSOR FOR
	select q.supervisor as supervisor, p.item as limits,
	count(*) as offsets,qq.name, p.partition_id
	from que q
	join que qq on qq.que_id = q.supervisor
	join partition p on p.name = qq.name
	where p.exam_id = examid and q.mytype = mytype
	group by qq.name;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_more_departments=1;
	SET no_more_departments=0;
	SET @total_offsets=0;
	SET @questions_count=0;
	START TRANSACTION;
	
	SET @examid = examid; 
	SET @mytype = mytype;
        PREPARE STMT FROM 
	"delete from question where exam_id = ? and q.mytype = ?";
	EXECUTE STMT USING @examid,@mytype;
	DEALLOCATE PREPARE STMT;

	SET @examid = examid; 
    SET @root_question_id = 1;
	/* Question table for question master label*/
    PREPARE STMT FROM 
	"insert into question (question_id,name,supervisor,exam_id)
		SELECT ? as question_id, 
		name, 0 as supervisor, ? as exam_id
		FROM exam where exam_id = ?";
	EXECUTE STMT USING @root_question_id, @examid, @examid;
	DEALLOCATE PREPARE STMT;

	OPEN partition_csr;
	dept_loop:WHILE(no_more_departments=0) DO
		FETCH partition_csr INTO supervisor,limits,offsets,part,part_id;

		IF no_more_departments=1 THEN
			LEAVE dept_loop;
		END IF;
		/* Question table for question label*/
		SET @part = part;
		SET @supervisor = supervisor;
			PREPARE STMT FROM 
		"insert into question (question_id,name,supervisor,exam_id) 
		values (?,?,?,?)";
		EXECUTE STMT USING @supervisor, @part, @root_question_id,@examid;
		DEALLOCATE PREPARE STMT;

		/* Question table for question*/
		SET @examid = examid; 
		SET @limits = limits; 
		SET @part_id = part_id;
		PREPARE STMT FROM 
		"insert into question (question_id,name,supervisor,exam_id,partition_name,partition_id, mytype, url, description, singleans)
		select que_id,qs.name,? as supervisor,? as exam_id,partition_name,? as partition_id, mytype, url, description, singleans  from
		(select q.que_id,
		q.name as name, qq.name as partition_name, q.mytype, q.url, q.description, q.singleans
		from que as q
		join que qq  on qq.que_id = q.supervisor
		order by rand())  as qs
		join
		(select name from partition where exam_id = ?) as p
		on qs.partition_name = p.name
			order by partition_name
		limit ?,?";
		EXECUTE STMT USING @supervisor, @examid, @part_id, @examid, @total_offsets, @limits;
		DEALLOCATE PREPARE STMT;

		SET @total_offsets = @total_offsets + offsets;
		SET @questions_count = @questions_count + limits;

	END WHILE dept_loop;

	/* Remove question no*/	
	/*
	SET @examid = examid; 
    PREPARE STMT FROM 
	"update question set name = regex_replace('^[0-9]+','',name) 
	where exam_id = ? and name REGEXP '^[0-9]+\. and mytype is not null';
	";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;
	*/
	/* Add new question no*/	
    PREPARE STMT FROM 
	"update question q join (select concat(rowid, name) as name,question_id from (select @rowid := @rowid + 1 as rowid,question_id, name
	from question,(select @rowid :=0) as init where exam_id = ? and mytype is not null order by supervisor) as que) as quest
	on q.question_id = quest.question_id
	set q.name = quest.name
	where q.exam_id = ? and q.mytype is not null
	";
	EXECUTE STMT USING @examid,@examid;
	DEALLOCATE PREPARE STMT;	
	/* Answer table*/
    PREPARE STMT FROM 
	"insert into answer select
	ans_id as answer_id,
	ans.name as name,
	que_id as question_id,
	multians,
	ans.myorder as myorder,
	ans.description as description,
	?
	from (SELECT * FROM `question` where question.exam_id = ?) as que
	join ans
	on que.question_id = ans.que_id";
	EXECUTE STMT USING @examid,@examid;
	DEALLOCATE PREPARE STMT;
	COMMIT;
	CLOSE partition_csr;
	SET no_more_departments=0; 
	
	SET @examid = examid; 
	SET @mytype = mytype;
        PREPARE STMT FROM 
	"update exampaper set mark = 2 where exampaper_id = ? and q.mytype = ?";
	EXECUTE STMT USING @examid,@mytype;
	DEALLOCATE PREPARE STMT;
END $$
DELIMITER ;

/*PROCEDURE----------------------------------------------------*/
DELIMITER $$
DROP PROCEDURE IF EXISTS `copyanswer` $$
CREATE PROCEDURE copyanswer(In examid INT(10))
BEGIN
/*
CALL copyanswer(11);
*/
/*Copy the correct quetion's  answer to questions' answers*/
	SET @examid = examid;
	PREPARE STMT FROM 
	"update question q
	join questions qs on q.question_id = qs.question_id
	set qs.singleans = q.singleans
	where q.exam_id = ? and q.mytype is not null;";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;

	PREPARE STMT FROM 
	"select q.question_id,q.singleans,qs.singleans
	from question q
	join questions qs on q.question_id = qs.question_id
	where q.exam_id = ? and q.mytype is not null;";
	EXECUTE STMT USING @examid;
	DEALLOCATE PREPARE STMT;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `prepaperpicker` $$
CREATE PROCEDURE prepaperpicker(In examid INT(10),
			In departmentid INT(10),In userid VARCHAR(40))
BEGIN
/*
CALL prepaperpicker(2,17,'S0002');
*/
	SET @examid = examid;
	SET @departmentid = departmentid;
	SET @userid = userid;
	
	PREPARE STMT FROM 
	"insert into exampaper (name,exam_id,department_id,user_id,
	remainder,limittime) select concat(concat(name,?),?),?,?,?,limittime,limittime
	from exam where exam_id = ?;";
	EXECUTE STMT USING @userid,@examid,@examid,@departmentid,@userid,@examid;
	DEALLOCATE PREPARE STMT;

END $$
DELIMITER ;

--
-- Definition of trigger `examcloser`
--
DROP TRIGGER /*!50030 IF EXISTS */ `examcloser`;
DELIMITER $$
CREATE TRIGGER `examcloser` AFTER UPDATE ON `exampaper` FOR EACH ROW
BEGIN
	DECLARE totalexam INT;
	DECLARE closeexam INT;
	SELECT count(*) INTO totalexam FROM exam e
	join exampaper ep on e.exam_id = ep.exam_id
	where e.exam_id = NEW.exam_id;

	SELECT count(*) INTO closeexam FROM exam e
	join exampaper ep on e.exam_id = ep.exam_id
	where e.exam_id = NEW.exam_id and ep.mark >=5;
	IF (totalexam = closeexam) and (totalexam > 0) THEN
		update exam set exam.mark =  9
		where exam.exam_id = NEW.exam_id;
	ELSE	
		update exam set exam.mark =  1
		where exam.exam_id = NEW.exam_id;
	END IF;
END $$
DELIMITER ;

--
-- Definition of trigger `paperpicker`
--

DROP TRIGGER /*!50030 IF EXISTS */ `paperpicker`;
DELIMITER $$
CREATE TRIGGER `paperpicker` AFTER INSERT ON `exampaper` 
FOR EACH ROW 
BEGIN
insert into questions (exampaper_id, name,myorder,question_id,url, description,mytype)
select exampaper.exampaper_id, question.name,question.supervisor,question.question_id,
question.url, question.description,question.mytype
from exam
join exampaper on exam.exam_id = exampaper.exam_id
join question on exam.exam_id = question.exam_id
where exampaper.exampaper_id = NEW.exampaper_id and
question.exam_id = NEW.exam_id
order by question.supervisor;

UPDATE questions qx JOIN
(select * from questions where questions.exampaper_id = NEW.exampaper_id) as qs
ON qx.myorder = qs.question_id
SET qx.supervisor = qs.questions_id
where qx.exampaper_id = NEW.exampaper_id;

/*UPDATE questions SET questions.myorder = null where questions.exampaper_id = NEW.exampaper_id;*/

insert into answers (questions_id, name,answer_id,description)
select questions.questions_id,  answer.name, answer.answer_id, answer.description
from questions 
join answer on questions.question_id = answer.question_id
join exampaper on questions.exampaper_id = exampaper.exampaper_id
where questions.exampaper_id = NEW.exampaper_id and
answer.exam_id = NEW.exam_id;

END $$
DELIMITER ;

DROP TRIGGER /*!50030 IF EXISTS */ `check_partition_insert_score`;
DELIMITER $$
CREATE TRIGGER check_partition_insert_score BEFORE INSERT ON partition FOR EACH ROW
BEGIN
IF NEW.score<0 THEN
   SET NEW.score=0;
ELSEIF NEW.score>100 THEN
   SET NEW.score=100;
END IF;
END $$
DELIMITER ;

DROP TRIGGER /*!50030 IF EXISTS */ `check_partition_update_score`;
DELIMITER $$
CREATE TRIGGER check_partition_update_score BEFORE UPDATE ON partition FOR EACH ROW
BEGIN
IF NEW.score<0 THEN
   SET NEW.score=0;
ELSEIF NEW.score>100 THEN
   SET NEW.score=100;
END IF;
END $$
DELIMITER ;

/*select regex_replace('^[0-9]+','',name) from quest where name REGEXP '^[0-9]+\.';*/
DELIMITER $$
DROP FUNCTION IF EXISTS `toyota`.`regex_replace` $$
CREATE FUNCTION `regex_replace`(pattern VARCHAR(1000),
replacement VARCHAR(1000),original VARCHAR(1000)) RETURNS varchar(1000) CHARSET utf8
DETERMINISTIC
BEGIN
 DECLARE question_no INT;
 DECLARE temp VARCHAR(1000);
 DECLARE ch VARCHAR(1);
 DECLARE i INT;
 DECLARE j INT;
 DECLARE qbTemp VARCHAR(1000);
 SET @question_no = @question_no+1; 
 SET i = 1;
 SET j = 1;
 SET temp = '';
 SET qbTemp = '';
 IF original REGEXP pattern THEN
  loop_label: LOOP
   IF i>CHAR_LENGTH(original) THEN
    LEAVE loop_label;
   END IF;
   SET ch = SUBSTRING(original,i,1);
   IF NOT ch REGEXP pattern THEN
    SET temp = CONCAT(temp,ch);
   ELSE
    SET temp = CONCAT(temp,replacement);
   END IF;
   SET i=i+1;
  END LOOP;
 ELSE
  SET temp = original;
 END IF;
 SET temp = TRIM(BOTH replacement FROM temp);
 SET temp = REPLACE(REPLACE(REPLACE(temp , CONCAT(replacement,replacement),CONCAT(replacement,'#')),CONCAT('#',replacement),''),'#','');
 RETURN temp;
END $$
DELIMITER ;


