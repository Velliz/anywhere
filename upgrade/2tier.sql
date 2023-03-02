ALTER TABLE constanta
    CHANGE COLUMN constID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN uniquekey unique_key varchar(250),
    CHANGE COLUMN constantaval constanta_val text,
    ADD COLUMN created  datetime   not null,
    ADD COLUMN modified timestamp  not null,
    ADD COLUMN cuid     int(11)    not null default 0,
    ADD COLUMN muid     int(11)    not null default 0,
    ADD COLUMN dflag    tinyint(1) not null default 0;

RENAME
    TABLE digitalsignusers TO digital_sign_users;

UPDATE digital_sign_users
SET dateOfBirth = '0000-00-00';

ALTER TABLE digital_sign_users
    CHANGE COLUMN userid user_id int(11),
    CHANGE COLUMN placeOfBirth place_of_birth varchar(100),
    CHANGE COLUMN dateOfBirth date_of_birth date,
    CHANGE COLUMN orgUnit org_unit varchar(50),
    CHANGE COLUMN workUnit work_unit varchar(50),
    CHANGE COLUMN isverified is_verified tinyint(1),
    CHANGE COLUMN callbackurl callback_url varchar(250),
    CHANGE COLUMN isspeciment is_speciment tinyint(1);

RENAME
    TABLE digitalsigns TO digital_signs;

ALTER TABLE digital_signs
    CHANGE COLUMN userid user_id varchar(250),
    CHANGE COLUMN documentname document_name varchar(250),
    CHANGE COLUMN digitalsignhash digital_sign_hash varchar(40),
    CHANGE COLUMN digitalsignsecure digital_sign_secure varchar(8);

ALTER TABLE excel
    CHANGE COLUMN EXCELID id int(11),
    CHANGE COLUMN userID user_id varchar(250),
    CHANGE COLUMN excelname excel_name varchar(255),
    CHANGE COLUMN columnspecs column_specs text,
    CHANGE COLUMN dataspecs data_specs text,
    CHANGE COLUMN requesttype request_type varchar(60),
    ADD COLUMN created  datetime   not null,
    ADD COLUMN modified timestamp  not null,
    ADD COLUMN cuid     int(11)    not null default 0,
    ADD COLUMN muid     int(11)    not null default 0,
    ADD COLUMN dflag    tinyint(1) not null default 0;

ALTER TABLE feedback
    CHANGE COLUMN feedbackID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN isapproved is_approved tinyint(1),
    CHANGE COLUMN approveddate approved_date datetime,
    CHANGE COLUMN feedbackresponds feedback_responds text,
    ADD COLUMN modified timestamp  not null,
    ADD COLUMN cuid     int(11)    not null default 0,
    ADD COLUMN muid     int(11)    not null default 0,
    ADD COLUMN dflag    tinyint(1) not null default 0;

ALTER TABLE images
    CHANGE COLUMN IMAGEID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN imagename image_name varchar(180),
    CHANGE COLUMN placeholdername placeholder_name varchar(180),
    CHANGE COLUMN placeholderfile placeholder_file longblob,
    CHANGE COLUMN requesttype request_type varchar(30),
    CHANGE COLUMN requesturl request_url text,
    CHANGE COLUMN requestsample request_sample text,
    CHANGE COLUMN requestsamplename request_sample_name varchar(255),
    CHANGE COLUMN requestsamplefile request_sample_file longblob,
    ADD COLUMN created  datetime   not null,
    ADD COLUMN modified timestamp  not null,
    ADD COLUMN cuid     int(11)    not null default 0,
    ADD COLUMN muid     int(11)    not null default 0,
    ADD COLUMN dflag    tinyint(1) not null default 0;

RENAME
    TABLE languageindices TO language_indices;

ALTER TABLE language_indices
    CHANGE COLUMN LANGID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN appname app_name varchar(180),
    ADD COLUMN created  datetime   not null,
    ADD COLUMN modified timestamp  not null,
    ADD COLUMN cuid     int(11)    not null default 0,
    ADD COLUMN muid     int(11)    not null default 0,
    ADD COLUMN dflag    tinyint(1) not null default 0;

RENAME
    TABLE logmail TO log_mail;

ALTER TABLE log_mail
    CHANGE COLUMN logid id int(11),
    CHANGE COLUMN MAILID mail_id int(11),
    CHANGE COLUMN userid user_id int(11),
    CHANGE COLUMN sentat sent_at timestamp,
    CHANGE COLUMN jsondata json_data text,
    CHANGE COLUMN resultdata result_data text,
    CHANGE COLUMN debuginfo debug_info text,
    CHANGE COLUMN processingtime processing_time text,
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;

RENAME
    TABLE logpdf TO log_pdf;

ALTER TABLE log_pdf
    CHANGE COLUMN logid id int(11),
    CHANGE COLUMN PDFID pdf_id int(11),
    CHANGE COLUMN userid user_id int(11),
    CHANGE COLUMN sentat sent_at timestamp,
    CHANGE COLUMN jsondata json_data longblob,
    CHANGE COLUMN creatorinfo creator_info text,
    CHANGE COLUMN processingtime processing_time text,
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;

ALTER TABLE mail
    CHANGE COLUMN MAILID id int(11),
    CHANGE COLUMN userid user_id int(11),
    CHANGE COLUMN mailname mail_name varchar(255),
    CHANGE COLUMN mailaddress mail_address varchar(255),
    CHANGE COLUMN mailpassword mail_password varchar(255),
    CHANGE COLUMN replyto reply_to varchar(255),
    CHANGE COLUMN smtpauth smtp_auth varchar(20),
    CHANGE COLUMN smtpsecure smtp_secure varchar(20),
    CHANGE COLUMN requesttype request_type varchar(20),
    CHANGE COLUMN requesturl request_url varchar(155),
    CHANGE COLUMN requestsample request_sample text,
    CHANGE COLUMN cssexternal css_external text,
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;

ALTER TABLE pdf
    CHANGE COLUMN PDFID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN reportname report_name varchar(255),
    CHANGE COLUMN phpscript php_script longblob,
    CHANGE COLUMN outputmode output_mode varchar(255),
    CHANGE COLUMN requesttype request_type varchar(20),
    CHANGE COLUMN requesturl request_url varchar(255),
    CHANGE COLUMN requestsample request_sample text CHARSET utf8 COLLATE utf8_general_ci,
    CHANGE COLUMN cssexternal css_external text,
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;

ALTER TABLE status
    CHANGE COLUMN ID id int(11),
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0,
    ADD COLUMN description varchar(255) not null;

ALTER TABLE testimonial
    CHANGE COLUMN testimonialID id int(11),
    CHANGE COLUMN userID user_id int(11),
    CHANGE COLUMN isvalid is_valid tinyint(1),
    CHANGE COLUMN validationdate validation_date datetime,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;

ALTER TABLE users
    CHANGE COLUMN ID id int(11),
    CHANGE COLUMN statusID status_id int(11),
    CHANGE COLUMN apikey api_key varchar(255),
    ADD COLUMN created datetime not null,
    ADD COLUMN modified timestamp not null,
    ADD COLUMN cuid int (11) not null default 0,
    ADD COLUMN muid int (11) not null default 0,
    ADD COLUMN dflag tinyint(1) not null default 0;
