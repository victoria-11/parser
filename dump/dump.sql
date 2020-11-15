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
    "days" character varying NOT NULL,
    "date_of_birth" date NOT NULL,
    CONSTRAINT "users_id" PRIMARY KEY ("id"),
    CONSTRAINT "users_category_id_fkey" FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT NOT DEFERRABLE
) WITH (oids = false);
