toc.dat                                                                                             0000600 0004000 0002000 00000013225 14753756454 0014466 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        PGDMP   0                    }            marcos    17.2 (Debian 17.2-1.pgdg120+1)     17.3 (Ubuntu 17.3-1.pgdg24.04+1)     /           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false         0           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false         1           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false         2           1262    16384    marcos    DATABASE     q   CREATE DATABASE marcos WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';
    DROP DATABASE marcos;
                     marcos    false                     2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                     pg_database_owner    false         3           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                        pg_database_owner    false    4         �            1259    16395    tokens    TABLE     �   CREATE TABLE public.tokens (
    id integer NOT NULL,
    idusuario integer NOT NULL,
    token character varying(255) NOT NULL,
    expiracaotoken timestamp without time zone NOT NULL
);
    DROP TABLE public.tokens;
       public         heap r       marcos    false    4         �            1259    16394    tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tokens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.tokens_id_seq;
       public               marcos    false    220    4         4           0    0    tokens_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.tokens_id_seq OWNED BY public.tokens.id;
          public               marcos    false    219         �            1259    16386    usuarios    TABLE     �   CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(20) NOT NULL,
    email character varying(50) NOT NULL,
    senha character varying(64) NOT NULL
);
    DROP TABLE public.usuarios;
       public         heap r       marcos    false    4         �            1259    16385    usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.usuarios_id_seq;
       public               marcos    false    4    218         5           0    0    usuarios_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;
          public               marcos    false    217         �           2604    16398 	   tokens id    DEFAULT     f   ALTER TABLE ONLY public.tokens ALTER COLUMN id SET DEFAULT nextval('public.tokens_id_seq'::regclass);
 8   ALTER TABLE public.tokens ALTER COLUMN id DROP DEFAULT;
       public               marcos    false    219    220    220         �           2604    16389    usuarios id    DEFAULT     j   ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);
 :   ALTER TABLE public.usuarios ALTER COLUMN id DROP DEFAULT;
       public               marcos    false    218    217    218         ,          0    16395    tokens 
   TABLE DATA           F   COPY public.tokens (id, idusuario, token, expiracaotoken) FROM stdin;
    public               marcos    false    220       3372.dat *          0    16386    usuarios 
   TABLE DATA           :   COPY public.usuarios (id, nome, email, senha) FROM stdin;
    public               marcos    false    218       3370.dat 6           0    0    tokens_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.tokens_id_seq', 1, true);
          public               marcos    false    219         7           0    0    usuarios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuarios_id_seq', 1, true);
          public               marcos    false    217         �           2606    16400    tokens tokens_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.tokens
    ADD CONSTRAINT tokens_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.tokens DROP CONSTRAINT tokens_pkey;
       public                 marcos    false    220         �           2606    16393    usuarios usuarios_email_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);
 E   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_email_key;
       public                 marcos    false    218         �           2606    16391    usuarios usuarios_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public                 marcos    false    218         �           2606    16401    tokens tokens_idusuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.tokens
    ADD CONSTRAINT tokens_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(id) ON DELETE CASCADE;
 F   ALTER TABLE ONLY public.tokens DROP CONSTRAINT tokens_idusuario_fkey;
       public               marcos    false    3220    218    220                                                                                                                                                                                                                                                                                                                                                                                   3372.dat                                                                                            0000600 0004000 0002000 00000000356 14753756454 0014300 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        1	1	eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE3Mzk2NjEyMzQsImlkIjoxLCJuYW1lIjoiZXUiLCJlbWFpbCI6ImV1QGVtYWlsLmNvbSIsImxvZ2luX3RpbWUiOiIyMDI1LTAyLTE0IDIzOjEzOjU0In0.l0-vmKq-e2C1hk977FesUzUiEzjr8biz-nNYnGwQKfE	2025-02-15 23:13:54
\.


                                                                                                                                                                                                                                                                                  3370.dat                                                                                            0000600 0004000 0002000 00000000124 14753756454 0014267 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        1	eu	eu@email.com	$2y$10$3bVaZGS0iLPBmyaA5Jjqc.Cytc3iCl77fcrxFziuIoojzi4p6Tna2
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                            restore.sql                                                                                         0000600 0004000 0002000 00000011646 14753756454 0015420 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        --
-- NOTE:
--
-- File paths need to be edited. Search for $$PATH$$ and
-- replace it with the path to the directory containing
-- the extracted data files.
--
--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2 (Debian 17.2-1.pgdg120+1)
-- Dumped by pg_dump version 17.3 (Ubuntu 17.3-1.pgdg24.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

DROP DATABASE marcos;
--
-- Name: marcos; Type: DATABASE; Schema: -; Owner: marcos
--

CREATE DATABASE marcos WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';


ALTER DATABASE marcos OWNER TO marcos;

\connect marcos

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: tokens; Type: TABLE; Schema: public; Owner: marcos
--

CREATE TABLE public.tokens (
    id integer NOT NULL,
    idusuario integer NOT NULL,
    token character varying(255) NOT NULL,
    expiracaotoken timestamp without time zone NOT NULL
);


ALTER TABLE public.tokens OWNER TO marcos;

--
-- Name: tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: marcos
--

CREATE SEQUENCE public.tokens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tokens_id_seq OWNER TO marcos;

--
-- Name: tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: marcos
--

ALTER SEQUENCE public.tokens_id_seq OWNED BY public.tokens.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: marcos
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(20) NOT NULL,
    email character varying(50) NOT NULL,
    senha character varying(64) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO marcos;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: marcos
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO marcos;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: marcos
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: tokens id; Type: DEFAULT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.tokens ALTER COLUMN id SET DEFAULT nextval('public.tokens_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Data for Name: tokens; Type: TABLE DATA; Schema: public; Owner: marcos
--

COPY public.tokens (id, idusuario, token, expiracaotoken) FROM stdin;
\.
COPY public.tokens (id, idusuario, token, expiracaotoken) FROM '$$PATH$$/3372.dat';

--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: marcos
--

COPY public.usuarios (id, nome, email, senha) FROM stdin;
\.
COPY public.usuarios (id, nome, email, senha) FROM '$$PATH$$/3370.dat';

--
-- Name: tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: marcos
--

SELECT pg_catalog.setval('public.tokens_id_seq', 1, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: marcos
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 1, true);


--
-- Name: tokens tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.tokens
    ADD CONSTRAINT tokens_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: tokens tokens_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: marcos
--

ALTER TABLE ONLY public.tokens
    ADD CONSTRAINT tokens_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          