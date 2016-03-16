
CREATE SCHEMA public
--AUTHORIZATION postgres;

GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO public;
COMMENT ON SCHEMA public
 -- IS 'standard public schema';
  
   create sequence project_id_project_seq;
  CREATE TABLE public.project
(
  id_project integer NOT NULL DEFAULT nextval('project_id_project_seq'::regclass),
  name_project character varying(35),
  id_user bigint,
  id_state bigint,
  priority integer,
  CONSTRAINT project_pkey PRIMARY KEY (id_project)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.project
  OWNER TO postgres;

  
 create sequence state_id_state_seq;
CREATE TABLE public.state
(
  id_state integer NOT NULL DEFAULT nextval('state_id_state_seq'::regclass),
  name_state character varying,
  CONSTRAINT state_pkey PRIMARY KEY (id_state)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.state
  OWNER TO postgres;

 create sequence task_id_task_seq;  
CREATE TABLE public.task
(
  id_task integer NOT NULL DEFAULT nextval('task_id_task_seq'::regclass),
  name_task character varying(35),
  id_project bigint,
  id_user bigint,
  id_state bigint,
  priority integer,
  CONSTRAINT task_pkey PRIMARY KEY (id_task)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.task
  OWNER TO postgres;

  create sequence user_id_user_seq;  
CREATE TABLE public."user"
(
  id_user integer NOT NULL DEFAULT nextval('user_id_user_seq'::regclass),
  name_user character varying(35),
  login_user character varying,
  password_user character varying,
  CONSTRAINT user_pkey PRIMARY KEY (id_user)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public."user"
  OWNER TO postgres;
