--
-- PostgreSQL database dump
--

-- Dumped from database version 16.0
-- Dumped by pg_dump version 16.0

-- Started on 2024-05-02 13:27:09

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 17632)
-- Name: news; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.news (
    id_site integer NOT NULL,
    site character(200) NOT NULL
);


ALTER TABLE public.news OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 17631)
-- Name: news_id_news_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.news_id_news_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.news_id_news_seq OWNER TO postgres;

--
-- TOC entry 4841 (class 0 OID 0)
-- Dependencies: 215
-- Name: news_id_news_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.news_id_news_seq OWNED BY public.news.id_site;


--
-- TOC entry 4688 (class 2604 OID 17635)
-- Name: news id_site; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.news ALTER COLUMN id_site SET DEFAULT nextval('public.news_id_news_seq'::regclass);


--
-- TOC entry 4835 (class 0 OID 17632)
-- Dependencies: 216
-- Data for Name: news; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.news (id_site, site) FROM stdin;
4	https://sozd.duma.gov.ru/bill/3153545-5                                                                                                                                                                 
1	https://sozd.duma.gov.ru/bill/31990-6                                                                                                                                                                   
3	https://sozd.duma.gov.ru/bill/31232-6                                                                                                                                                                   
5	https://sozd.duma.gov.ru/bill/                                                                                                                                                                          
7	https://sozd.duma.gov.ru/bill/366426-7                                                                                                                                                                  
8	https://sozd.duma.gov.ru/bill/31990-6                                                                                                                                                                   
\.


--
-- TOC entry 4842 (class 0 OID 0)
-- Dependencies: 215
-- Name: news_id_news_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.news_id_news_seq', 8, true);


--
-- TOC entry 4690 (class 2606 OID 17637)
-- Name: news news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.news
    ADD CONSTRAINT news_pkey PRIMARY KEY (id_site);


-- Completed on 2024-05-02 13:27:09

--
-- PostgreSQL database dump complete
--

