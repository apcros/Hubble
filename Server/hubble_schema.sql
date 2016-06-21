SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET search_path = public, pg_catalog;

CREATE SCHEMA public;
ALTER SCHEMA public OWNER TO postgres;
COMMENT ON SCHEMA public IS 'standard public schema';

SET search_path = public, pg_catalog;
SET default_tablespace = '';
SET default_with_oids = false;

CREATE TABLE "USER" (
  "id" integer NOT NULL,
  "nickname" text,
  "email" text NOT NULL,
  "rank" integer,
  "last_logged" time
  );
ALTER TABLE public."USER" OWNER TO hubble_user;
CREATE SEQUENCE "USER_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public."USER_id_seq" OWNER TO hubble_user;
ALTER SEQUENCE "USER_id_seq" OWNED BY "USER"."id";
ALTER TABLE ONLY "USER" ADD CONSTRAINT "USER_pkey" PRIMARY KEY ("id");

CREATE TABLE "DEVICE" (
  "id" integer NOT NULL,
  "uuid" text NOT NULL,
  "name" text,
  "data" json,
  "last_updated" time
 );
 ALTER TABLE public."DEVICE" OWNER TO hubble_user;
 CREATE SEQUENCE "DEVICE_id_seq"
     START WITH 1
     INCREMENT BY 1
     NO MINVALUE
     NO MAXVALUE
     CACHE 1;
 ALTER TABLE public."DEVICE_id_seq" OWNER TO hubble_user;
 ALTER SEQUENCE "DEVICE_id_seq" OWNED BY "DEVICE"."id";
 ALTER TABLE ONLY "DEVICE" ADD CONSTRAINT "DEVICE_pkey" PRIMARY KEY ("id");
 
REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;