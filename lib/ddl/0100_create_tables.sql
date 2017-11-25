/*================================================================================*/
/* DDL SCRIPT                                                                     */
/*================================================================================*/
/*  Title    : ABC-Framework: Core Login Handler                                  */
/*  FileName : abc-login-handler-core.ecm                                         */
/*  Platform : MySQL 5                                                            */
/*  Version  :                                                                    */
/*  Date     : zaterdag 25 november 2017                                          */
/*================================================================================*/
/*================================================================================*/
/* CREATE TABLES                                                                  */
/*================================================================================*/

CREATE TABLE `ABC_AUTH_LOGIN_RESPONSE` (
  `lgr_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `lgr_label` VARCHAR(40) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`lgr_id`)
);

CREATE TABLE `ABC_AUTH_LOGIN_LOG` (
  `llg_id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `lgr_id` TINYINT UNSIGNED NOT NULL,
  `ses_id` INTEGER UNSIGNED,
  `usr_id` INTEGER UNSIGNED,
  `llg_timestamp` TIMESTAMP DEFAULT now() NOT NULL,
  `llg_user_name` VARCHAR(64),
  `llg_ip4` INT UNSIGNED,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`llg_id`)
);

/*
COMMENT ON COLUMN `ABC_AUTH_LOGIN_LOG`.`llg_ip4`
The IPv4 of the user agent.
*/

/*================================================================================*/
/* CREATE INDEXES                                                                 */
/*================================================================================*/

CREATE INDEX `wrd_id` ON `ABC_AUTH_LOGIN_RESPONSE` (`wrd_id`);

CREATE INDEX `IX_ABC_AUTH_LOGIN_LOG1` ON `ABC_AUTH_LOGIN_LOG` (`llg_timestamp`);

CREATE INDEX `IX_FK_ABC_AUTH_LOGIN_LOG` ON `ABC_AUTH_LOGIN_LOG` (`cmp_id`);

CREATE INDEX `IX_FK_ABC_AUTH_LOGIN_LOG1` ON `ABC_AUTH_LOGIN_LOG` (`ses_id`);

CREATE INDEX `IX_FK_ABC_AUTH_LOGIN_LOG2` ON `ABC_AUTH_LOGIN_LOG` (`usr_id`);

CREATE INDEX `IX_FK_ABC_AUTH_LOGIN_LOG3` ON `ABC_AUTH_LOGIN_LOG` (`lgr_id`);

/*================================================================================*/
/* CREATE FOREIGN KEYS                                                            */
/*================================================================================*/

ALTER TABLE `ABC_AUTH_LOGIN_RESPONSE`
  ADD CONSTRAINT `FK_ABC_AUTH_LOGIN_RESPONSE_ABC_BABEL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `ABC_BABEL_WORD` (`wrd_id`);

ALTER TABLE `ABC_AUTH_LOGIN_LOG`
  ADD CONSTRAINT `FK_ABC_AUTH_LOGIN_LOG_ABC_AUTH_LOGIN_RESPONSE`
  FOREIGN KEY (`lgr_id`) REFERENCES `ABC_AUTH_LOGIN_RESPONSE` (`lgr_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;
