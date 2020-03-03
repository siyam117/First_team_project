CREATE TABLE `first_team_project`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `password_salt` VARCHAR(255) NULL,
  `created_timestamp` INT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);

CREATE TABLE `first_team_project`.`temp_users` (
  `temp_user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `lobby_id` VARCHAR(10) NULL,
  PRIMARY KEY (`temp_user_id`));

CREATE TABLE `first_team_project`.`stories` (
  `story_id` INT NOT NULL AUTO_INCREMENT,
  `creator_user_id` INT NULL,
  `title` VARCHAR(255) NULL,
  `section_amount` INT NULL,
  `section_length` INT NULL,
  PRIMARY KEY (`story_id`));

CREATE TABLE `first_team_project`.`sessions` (
  `session_id` INT NOT NULL AUTO_INCREMENT,
  `session_token` VARCHAR(255) NULL,
  `session_serial` VARCHAR(255) NULL,
  `session_timestamp` INT NULL,
  `session_user_id` INT NULL,
  PRIMARY KEY (`session_id`));

CREATE TABLE `first_team_project`.`sections` (
  `section_id` INT NOT NULL AUTO_INCREMENT,
  `story_id` INT NOT NULL,
  `writer_user_id` INT NULL,
  `section_order` INT NOT NULL,
  `section_text` MEDIUMTEXT NULL,
  PRIMARY KEY (`section_id`));

CREATE TABLE `first_team_project`.`private_stories` (
  `lobby_id` VARCHAR(10) NOT NULL,
  `creator_user_id` INT NULL,
  `title` VARCHAR(255) NULL,
  PRIMARY KEY (`lobby_id`));

CREATE TABLE `first_team_project`.`private_sections` (
  `private_section_id` INT NOT NULL AUTO_INCREMENT,
  `lobby_id` VARCHAR(10) NULL,
  `section_text` MEDIUMTEXT NULL,
  `writer_user_id` INT NULL,
  PRIMARY KEY (`private_section_id`));
