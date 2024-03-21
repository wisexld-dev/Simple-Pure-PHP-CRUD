--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

-- Started on 2024-03-21 17:26:45

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'WIN1252';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 16399)
-- Name: clientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clientes (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    cpf character(11) NOT NULL,
    endereco text
);


ALTER TABLE public.clientes OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16398)
-- Name: cliente_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cliente_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cliente_id_seq OWNER TO postgres;

--
-- TOC entry 4868 (class 0 OID 0)
-- Dependencies: 215
-- Name: cliente_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cliente_id_seq OWNED BY public.clientes.id;


--
-- TOC entry 220 (class 1259 OID 16420)
-- Name: ordemservico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ordemservico (
    numero_ordem integer NOT NULL,
    data_abertura date DEFAULT CURRENT_DATE NOT NULL,
    id_cliente integer,
    nome_consumidor character varying(100) NOT NULL,
    cpf_consumidor character(11) NOT NULL
);


ALTER TABLE public.ordemservico OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16419)
-- Name: ordemdeservico_numero_ordem_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ordemdeservico_numero_ordem_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ordemdeservico_numero_ordem_seq OWNER TO postgres;

--
-- TOC entry 4869 (class 0 OID 0)
-- Dependencies: 219
-- Name: ordemdeservico_numero_ordem_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ordemdeservico_numero_ordem_seq OWNED BY public.ordemservico.numero_ordem;


--
-- TOC entry 221 (class 1259 OID 16432)
-- Name: ordemservico_produtos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ordemservico_produtos (
    numero_ordem integer NOT NULL,
    id_produto integer NOT NULL
);


ALTER TABLE public.ordemservico_produtos OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16410)
-- Name: produtos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produtos (
    id integer NOT NULL,
    codigo character varying(50) NOT NULL,
    descricao text,
    status boolean DEFAULT true,
    tempo_garantia date
);


ALTER TABLE public.produtos OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16409)
-- Name: produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produtos_id_seq OWNER TO postgres;

--
-- TOC entry 4870 (class 0 OID 0)
-- Dependencies: 217
-- Name: produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produtos_id_seq OWNED BY public.produtos.id;


--
-- TOC entry 4702 (class 2604 OID 16402)
-- Name: clientes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes ALTER COLUMN id SET DEFAULT nextval('public.cliente_id_seq'::regclass);


--
-- TOC entry 4705 (class 2604 OID 16423)
-- Name: ordemservico numero_ordem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico ALTER COLUMN numero_ordem SET DEFAULT nextval('public.ordemdeservico_numero_ordem_seq'::regclass);


--
-- TOC entry 4703 (class 2604 OID 16413)
-- Name: produtos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos ALTER COLUMN id SET DEFAULT nextval('public.produtos_id_seq'::regclass);


--
-- TOC entry 4708 (class 2606 OID 16408)
-- Name: clientes cliente_cpf_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT cliente_cpf_key UNIQUE (cpf);


--
-- TOC entry 4710 (class 2606 OID 16406)
-- Name: clientes cliente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT cliente_pkey PRIMARY KEY (id);


--
-- TOC entry 4714 (class 2606 OID 16426)
-- Name: ordemservico ordemdeservico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico
    ADD CONSTRAINT ordemdeservico_pkey PRIMARY KEY (numero_ordem);


--
-- TOC entry 4716 (class 2606 OID 16436)
-- Name: ordemservico_produtos ordemdeservico_produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico_produtos
    ADD CONSTRAINT ordemdeservico_produtos_pkey PRIMARY KEY (numero_ordem, id_produto);


--
-- TOC entry 4712 (class 2606 OID 16418)
-- Name: produtos produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id);


--
-- TOC entry 4717 (class 2606 OID 16427)
-- Name: ordemservico ordemdeservico_id_cliente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico
    ADD CONSTRAINT ordemdeservico_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id) ON DELETE CASCADE;


--
-- TOC entry 4718 (class 2606 OID 16437)
-- Name: ordemservico_produtos ordemdeservico_produtos_id_ordem_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico_produtos
    ADD CONSTRAINT ordemdeservico_produtos_id_ordem_fkey FOREIGN KEY (numero_ordem) REFERENCES public.ordemservico(numero_ordem) ON DELETE CASCADE;


--
-- TOC entry 4719 (class 2606 OID 16442)
-- Name: ordemservico_produtos ordemdeservico_produtos_id_produto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordemservico_produtos
    ADD CONSTRAINT ordemdeservico_produtos_id_produto_fkey FOREIGN KEY (id_produto) REFERENCES public.produtos(id) ON DELETE CASCADE;


-- Completed on 2024-03-21 17:26:46

--
-- PostgreSQL database dump complete
--

