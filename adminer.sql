-- Adminer 4.7.7 PostgreSQL dump

DROP TABLE IF EXISTS "categories";
DROP SEQUENCE IF EXISTS categories_id_seq;
CREATE SEQUENCE categories_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."categories" (
    "id" integer DEFAULT nextval('categories_id_seq') NOT NULL,
    "name" character varying NOT NULL,
    CONSTRAINT "categories_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "categories" ("id", "name") VALUES
(1,  'Красный'),
(2,  'Желтый');


DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."users" (
    "id" integer DEFAULT nextval('users_id_seq') NOT NULL,
    "full_name" character varying NOT NULL,
    "phone" character varying NOT NULL,
    "category_id" integer NOT NULL,
    "date_of_birth" date NOT NULL,
    CONSTRAINT "users_id" PRIMARY KEY ("id"),
    CONSTRAINT "users_category_id_fkey" FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT NOT DEFERRABLE
) WITH (oids = false);

DROP TABLE IF EXISTS "days";
DROP SEQUENCE IF EXISTS days_id_seq;
CREATE SEQUENCE days_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."days" (
    "id" integer DEFAULT nextval('days_id_seq') NOT NULL,
    "name" character varying NOT NULL,
    CONSTRAINT "days_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "days" ("id", "name") VALUES
(6,  'Суббота'),
(5,  'Пятница'),
(4,  'Четверг'),
(3,  'Среда'),
(2,  'Вторник'),
(1,  'Понедельник');

DROP TABLE IF EXISTS "day_user";
DROP SEQUENCE IF EXISTS day_user_id_seq;
CREATE SEQUENCE day_user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."day_user" (
    "id" integer DEFAULT nextval('day_user_id_seq') NOT NULL,
    "user_id" integer NOT NULL,
    "day_id" integer NOT NULL,
    CONSTRAINT "day_user_id" PRIMARY KEY ("id"),
    CONSTRAINT "day_user_day_id_fkey" FOREIGN KEY (day_id) REFERENCES days(id) ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "day_user_user_id_fkey" FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

-- 2020-11-13 21:20:57.9729+00
