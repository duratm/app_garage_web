--
-- PostgreSQL database dump
--

-- Dumped from database version 14.7
-- Dumped by pg_dump version 15.2

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

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: garagesports
--

-- *not* creating schema, since initdb creates it

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: askforintervention; Type: TABLE; Schema: public; Owner: garagesports
--
CREATE DATABASE postgres;

CREATE TABLE public.askforintervention (
    numdde integer NOT NULL,
    date date NOT NULL,
    hour character varying NOT NULL,
    askdescription character varying,
    currentkm integer,
    askstate character varying,
    askfordevis boolean DEFAULT false,
    vehicleimmat character varying,
    customerid integer,
    operatorlogin character varying,
    billnum integer,
    CONSTRAINT askforintervention_askstate_check CHECK ((((askstate)::text = 'TERMINEE'::text) OR ((askstate)::text = 'EN COURS'::text) OR ((askstate)::text = 'ANNULEE'::text) OR ((askstate)::text = 'PLANIFIEE'::text)))
);



--
-- Name: askforintervention_numdde_seq; Type: SEQUENCE; Schema: public; Owner: garagesports
--

CREATE SEQUENCE public.askforintervention_numdde_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: askforintervention_numdde_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: garagesports
--

ALTER SEQUENCE public.askforintervention_numdde_seq OWNED BY public.askforintervention.numdde;


--
-- Name: bill; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.bill (
    billnum integer NOT NULL,
    billdate date NOT NULL,
    vatvalue integer,
    nettopay integer,
    billstatus character varying NOT NULL,
    CONSTRAINT bill_billstatus_check CHECK ((((billstatus)::text = 'PAYER'::text) OR ((billstatus)::text = 'EN COURS'::text)))
);



--
-- Name: brand; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.brand (
    numbrand integer NOT NULL,
    libelle character varying
);



--
-- Name: customer; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.customer (
    customerid integer NOT NULL,
    name character varying NOT NULL,
    surname character varying NOT NULL,
    address character varying,
    postalcode character varying,
    city character varying,
    tel character varying,
    mail character varying,
    datecreation date,
    mdp character varying
);



--
-- Name: customer_customerid_seq; Type: SEQUENCE; Schema: public; Owner: garagesports
--

CREATE SEQUENCE public.customer_customerid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: customer_customerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: garagesports
--

ALTER SEQUENCE public.customer_customerid_seq OWNED BY public.customer.customerid;


--
-- Name: item; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.item (
    itemid integer NOT NULL,
    itemname character varying NOT NULL,
    itemtype character varying NOT NULL,
    dutyfreecurrentup double precision NOT NULL,
    CONSTRAINT item_itemtype_check CHECK ((((itemtype)::text = 'PIECE'::text) OR ((itemtype)::text = 'FOURNITURE'::text)))
);



--
-- Name: madeope; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.madeope (
    numdde integer NOT NULL,
    codeope integer NOT NULL,
    couthoraireht double precision,
    duree double precision
);



--
-- Name: model; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.model (
    nummodel integer NOT NULL,
    libelle character varying,
    numbrand integer
);



--
-- Name: operation; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.operation (
    codeope integer NOT NULL,
    libelle character varying,
    duree character varying,
    codetarif integer
);



--
-- Name: operator; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.operator (
    name character varying NOT NULL,
    firstname character varying NOT NULL,
    login character varying NOT NULL,
    mdp character varying NOT NULL,
    function character varying NOT NULL,
    CONSTRAINT operator_function_check CHECK (((function)::text = ANY (ARRAY[('operator'::character varying)::text, ('chief'::character varying)::text])))
);



--
-- Name: planitem; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.planitem (
    numdde integer NOT NULL,
    itemid integer NOT NULL,
    qtt double precision,
    updutyfree double precision
);



--
-- Name: planope; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.planope (
    numdde integer NOT NULL,
    codeope integer NOT NULL,
    couthoraireht double precision,
    duree double precision
);



--
-- Name: tarif_mo; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.tarif_mo (
    codetarif integer NOT NULL,
    couthoraireactuelht integer NOT NULL
);



--
-- Name: tarif_mo_codetarif_seq; Type: SEQUENCE; Schema: public; Owner: garagesports
--

CREATE SEQUENCE public.tarif_mo_codetarif_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: tarif_mo_codetarif_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: garagesports
--

ALTER SEQUENCE public.tarif_mo_codetarif_seq OWNED BY public.tarif_mo.codetarif;


--
-- Name: useitem; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.useitem (
    itemid integer NOT NULL,
    qtt double precision,
    updutyfree double precision,
    numdde integer NOT NULL
);



--
-- Name: vehicle; Type: TABLE; Schema: public; Owner: garagesports
--

CREATE TABLE public.vehicle (
    noimmat character varying NOT NULL,
    noserie character varying NOT NULL,
    releasedate date,
    nummodel integer,
    customerid integer NOT NULL,
    appartient boolean DEFAULT true
);



--
-- Name: askforintervention numdde; Type: DEFAULT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention ALTER COLUMN numdde SET DEFAULT nextval('public.askforintervention_numdde_seq'::regclass);


--
-- Name: customer customerid; Type: DEFAULT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.customer ALTER COLUMN customerid SET DEFAULT nextval('public.customer_customerid_seq'::regclass);


--
-- Name: tarif_mo codetarif; Type: DEFAULT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.tarif_mo ALTER COLUMN codetarif SET DEFAULT nextval('public.tarif_mo_codetarif_seq'::regclass);


--
-- Data for Name: askforintervention; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.askforintervention VALUES (41, '2023-01-11', '09h00', 'Besoin de changer le siège passager', 77000, 'PLANIFIEE', false, 'ZZ-488-XX', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (42, '2023-01-13', '08h15', 'Changement de catalyseur', 77000, 'PLANIFIEE', false, 'ZZ-488-XX', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (6, '2023-01-04', '15h00', 'J''ai besoin d''un nettoyage ', 55000, 'TERMINEE', true, 'KE-883-AN', 13, 'viardpa', NULL);
INSERT INTO public.askforintervention VALUES (7, '2023-01-06', '10h30', 'Lors d''une course privé j''ai complètement rayé ma voiture', 20000, 'TERMINEE', false, 'KE-883-AN', 13, 'viardpa', NULL);
INSERT INTO public.askforintervention VALUES (8, '2023-01-07', '11h15', 'J''ai oublié, j''ai besoin de vidangé mon huile de boite, j''ai une voiture mécanique', 14000, 'TERMINEE', false, 'HJ-663-IE', 13, 'viardpa', NULL);
INSERT INTO public.askforintervention VALUES (28, '2023-01-06', '08h15', 'VERIFICATION DES PNEUS', 112, 'PLANIFIEE', false, 'ER-778-GK', 21, NULL, NULL);
INSERT INTO public.askforintervention VALUES (30, '2023-01-09', '08h00', 'Problème démarreur', 75000, 'PLANIFIEE', false, 'XB-344-HA', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (31, '2023-01-09', '08h15', 'Problème jante', 75000, 'PLANIFIEE', false, 'XB-344-HA', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (32, '2023-01-09', '09h00', 'J''ai besoin d''une révision', 12000, 'PLANIFIEE', false, 'XF-373-EJ', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (33, '2023-01-10', '16h30', 'Erreur tableau de bord', 15000, 'PLANIFIEE', false, 'XF-373-EJ', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (34, '2023-01-11', '16h00', 'Le pot crache des flammes ', 14000, 'PLANIFIEE', false, 'XF-373-EJ', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (35, '2023-01-11', '15h45', 'Visite de routine', 14000, 'PLANIFIEE', false, 'XF-373-EJ', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (36, '2023-01-11', '15h30', 'Mon turbo est encrassé', 14000, 'PLANIFIEE', false, 'XB-344-HA', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (38, '2023-01-11', '09h30', 'La peinture est a refaire', 150000, 'PLANIFIEE', false, 'AQ-919-PE', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (5, '2023-01-02', '08h15', 'changement des pneu pour des pneu hiver', 213, 'EN COURS', false, 'FB-473-HG', 12, 'micoulea', NULL);
INSERT INTO public.askforintervention VALUES (4, '2023-01-06', '10h00', 'Ma portière a été rayée lors de mon road-trip, j''ai besoin de refaire la peintue.', 14000, 'TERMINEE', false, 'FB-473-HG', 12, 'viardpa', NULL);
INSERT INTO public.askforintervention VALUES (37, '2023-01-12', '10h45', 'Encore un problème de moteur', 14000, 'TERMINEE', false, 'XF-373-EJ', 9, 'viardpa', NULL);
INSERT INTO public.askforintervention VALUES (47, '2023-01-12', '08h00', 'pb pneu
peinture rayée', 12131, 'PLANIFIEE', false, 'XX-799-KC', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (40, '2023-01-11', '09h15', 'Problème vitre arrière', 46000, 'PLANIFIEE', false, 'AQ-919-PE', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (48, '2023-01-07', '10h00', 'pneu mou
pb demarreur
peinture', 121210, 'TERMINEE', false, 'XZ-919-KE', 12, 'farretq', NULL);
INSERT INTO public.askforintervention VALUES (49, '2023-01-13', '08h00', 'peinture rayée', 12133, 'PLANIFIEE', false, 'AQ-919-PE', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (50, '2023-01-10', '10h00', 'Je comprends pas pourquoi le select il bouffe le css
', 121219, 'PLANIFIEE', false, 'AZ-236-ER', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (51, '2023-02-02', '08h30', '', 185000, 'PLANIFIEE', false, 'BV185HT', 18, NULL, NULL);
INSERT INTO public.askforintervention VALUES (52, '2023-02-10', '08h15', '', 12000, 'PLANIFIEE', false, 'AQ-919-PE', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (53, '2023-03-09', '09h30', 'Leo a cassé tout', 12000, 'PLANIFIEE', false, 'AQ-919-PE', 9, NULL, NULL);
INSERT INTO public.askforintervention VALUES (54, '2023-03-10', '09h45', 'eeeeeee', 12000, 'PLANIFIEE', false, 'XX-799-KC', 9, NULL, NULL);


--
-- Data for Name: bill; Type: TABLE DATA; Schema: public; Owner: garagesports
--



--
-- Data for Name: brand; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.brand VALUES (1, 'Mclaren');
INSERT INTO public.brand VALUES (2, 'Ferrari');
INSERT INTO public.brand VALUES (3, 'Mercedes');
INSERT INTO public.brand VALUES (4, 'Renault');
INSERT INTO public.brand VALUES (5, 'Peugeot');
INSERT INTO public.brand VALUES (6, 'Nissan');


--
-- Data for Name: customer; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.customer VALUES (15, 'Micoulet', 'Alex', '50 route de chinon', '07370', 'Eclassan', '0668681533', 'alex.micoulet@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$aFhKTXdUT1pEaEhhM1JRLg$qMRvD5kxDJ19glOulZLn4gxSMiZIyEpyiOzVDD8Ghwg');
INSERT INTO public.customer VALUES (10, 'durat', 'mathias', '16 rue des basses crozettes', '26000', 'valence', '0648305383', 'duratmathias@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$Zm44QTQ2QndVdzFtVVp4Zw$MifeRuGlF0l1b71FDcJCr0k7nLGSzVEiJt7DN6UBYxI');
INSERT INTO public.customer VALUES (16, 'Poisson', 'Dorothée', '143 avenue Belle', '93000', 'Livry-Gargan', '0650909983', 'kafewzumba1@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$Q3pHeWIzakh0MnFVZkN6bQ$UtcNF6YWxJ8HArlZwFSm60KCnxbmmpZNPEJSuTDCn3A');
INSERT INTO public.customer VALUES (17, 'Suka', 'Max', '50 route de chinon', '07370', 'Eclassan', '0645128674', 'alexmicoulet.pro@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$LnBlaElvQ0dtZC94Y1g2Rw$9hyOnSsWehudl80nLl/vt9mhViWrcK4dz42cIUButjE');
INSERT INTO public.customer VALUES (12, 'Klagon', 'Robert', '13 rue des Lilas', '95000', 'Paris', '0765349527', 'redyoffwolf@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$SlloM0lBa1VmZjh1RDB1ag$xBe3gPWYZ3it79GE37rDSxGtMac6JuIcLtollErpMOU');
INSERT INTO public.customer VALUES (13, 'Zidane', 'Zinedine', '34 rue des chèvres', '26000', 'Valence', '0652817436', 'magecops83@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$bDgyVlo4Y3FkLnBnanRpRA$ZluzrUFSDQD8iCedERVp1/VXN9mAfDp97D0tp/VZUEA');
INSERT INTO public.customer VALUES (24, 'Farret', 'Quentin', '7 rue de robinson', '26000', 'Valence', '0636114808', 'quentin.farret@gmail.com', '2023-01-06', '$argon2id$v=19$m=65536,t=4,p=1$bXdJVHlWSzZ3aUZHUGQ5Uw$TnSRWt/xLnQuFSZqMjNf06K2+l1OfEu7UXSNRBdM6MI');
INSERT INTO public.customer VALUES (18, 'ACCART--MMA', 'Timothée', 'Chez moi pd', '83600', 'Fréjus', '0677093323', 'pingoleon.arcus@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$bjBwcEY0R3d3VldJRFRwdw$TJCSytkSqgaRRAkFVUufMH0PQjsJx9dJPu83bFaBHdw');
INSERT INTO public.customer VALUES (9, 'Viard', 'Paul', '130 avenue Schéma de Parcour', '83700', 'Saint-Raphael', '0750909983', 'viardpaul83@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$S2lKbzZGeHRwZDVvSVBMYg$+1ziWeZO8YJMpa9BjMMkG5XwQ7gzLbelnBWonn2Ep+E');
INSERT INTO public.customer VALUES (19, 'Duprès', 'Romain', '45 rue Courcelles', '26000', 'Valence', '0645219361', 'pmillerioux.studies@gmail.com', '2023-01-04', '$argon2id$v=19$m=65536,t=4,p=1$eWdVOVV6VDlKU2dTVVQwWQ$kYaH4vFJz3kk4UL9ibtUoPJGLP83BdExudnhL4eCSaI');
INSERT INTO public.customer VALUES (21, 'micoulet', 'virginie', '50route de chinon', '07370', 'Eclassan', '', 'virginie.micoulet07@gmail.com', '2023-01-05', '$argon2id$v=19$m=65536,t=4,p=1$QzhwTnptSGlEbGU2OTNYUw$NUDGx5vYlPSVAv2IOoKAV/8b0A+0sHp98VXY80YUnQ8');


--
-- Data for Name: item; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.item VALUES (2, 'lave-glace', 'FOURNITURE', 3.2);
INSERT INTO public.item VALUES (4, 'ampoules', 'FOURNITURE', 3.2);
INSERT INTO public.item VALUES (1, 'retroviseur', 'PIECE', 3.4);
INSERT INTO public.item VALUES (3, 'huile moteur', 'FOURNITURE', 3.2);
INSERT INTO public.item VALUES (5, 'Peinture', 'FOURNITURE', 10);
INSERT INTO public.item VALUES (6, 'huile boîte mécanique', 'FOURNITURE', 5);
INSERT INTO public.item VALUES (7, '2 x Pneu', 'PIECE', 90);
INSERT INTO public.item VALUES (8, '1 x Pneu', 'PIECE', 45);
INSERT INTO public.item VALUES (9, 'huile boîte automatique', 'FOURNITURE', 10);
INSERT INTO public.item VALUES (10, 'Catayseur', 'PIECE', 100);
INSERT INTO public.item VALUES (11, 'Plaquette de frein', 'PIECE', 50);
INSERT INTO public.item VALUES (12, 'Démarreur', 'PIECE', 99);


--
-- Data for Name: madeope; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.madeope VALUES (6, 11, 70, 3);
INSERT INTO public.madeope VALUES (6, 2, 14, 2);
INSERT INTO public.madeope VALUES (8, 16, 45, 1);
INSERT INTO public.madeope VALUES (7, 15, 2450, 10);
INSERT INTO public.madeope VALUES (37, 18, 23, 2);
INSERT INTO public.madeope VALUES (37, 19, 45, 0.3);
INSERT INTO public.madeope VALUES (37, 15, 145, 10);
INSERT INTO public.madeope VALUES (4, 14, 299, 5);
INSERT INTO public.madeope VALUES (48, 18, 23, 2);
INSERT INTO public.madeope VALUES (48, 19, 45, 0.3);
INSERT INTO public.madeope VALUES (48, 15, 145, 10);


--
-- Data for Name: model; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.model VALUES (1, 'F1', 1);
INSERT INTO public.model VALUES (2, 'Senna', 1);
INSERT INTO public.model VALUES (5, '570GT', 1);
INSERT INTO public.model VALUES (3, 'Enzo', 2);
INSERT INTO public.model VALUES (7, 'F40', 2);
INSERT INTO public.model VALUES (4, 'G500', 3);
INSERT INTO public.model VALUES (6, 'GLC', 3);
INSERT INTO public.model VALUES (8, 'Clio', 4);
INSERT INTO public.model VALUES (9, 'Kangoo', 4);
INSERT INTO public.model VALUES (10, 'Captur', 4);
INSERT INTO public.model VALUES (21, '508 SW', 5);
INSERT INTO public.model VALUES (22, 'e-208', 5);
INSERT INTO public.model VALUES (23, 'e-2008', 5);
INSERT INTO public.model VALUES (24, 'X-Trail', 6);
INSERT INTO public.model VALUES (25, 'Qashqai', 6);
INSERT INTO public.model VALUES (26, 'Juke', 6);
INSERT INTO public.model VALUES (27, 'Ariya', 6);
INSERT INTO public.model VALUES (28, 'Micra', 6);
INSERT INTO public.model VALUES (29, 'Leaf', 6);
INSERT INTO public.model VALUES (11, 'Scenic', 4);
INSERT INTO public.model VALUES (12, 'Twingo', 4);
INSERT INTO public.model VALUES (13, 'Arkana', 4);
INSERT INTO public.model VALUES (14, 'ZOE', 4);
INSERT INTO public.model VALUES (15, '3008', 5);
INSERT INTO public.model VALUES (16, '308', 5);
INSERT INTO public.model VALUES (17, '208', 5);
INSERT INTO public.model VALUES (18, '2008', 5);
INSERT INTO public.model VALUES (19, '5008', 5);
INSERT INTO public.model VALUES (20, '408', 5);


--
-- Data for Name: operation; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.operation VALUES (2, 'Vidange huile moteur', '2.00', 11);
INSERT INTO public.operation VALUES (3, 'Réparation rétroviseur', '2.00', 12);
INSERT INTO public.operation VALUES (5, 'Redressage parechoc', '1', 12);
INSERT INTO public.operation VALUES (6, 'Changement pneu + équilibrage', '1', 13);
INSERT INTO public.operation VALUES (7, 'Remplacement plaquettes frein', '2.00', 14);
INSERT INTO public.operation VALUES (8, 'Remplacement catalyseur', '3.00', 15);
INSERT INTO public.operation VALUES (9, 'Entretien climatisation', '2.00', 14);
INSERT INTO public.operation VALUES (10, 'Réglage des phares', '1.00', 13);
INSERT INTO public.operation VALUES (11, 'Nettoyage turbo', '3.00', 15);
INSERT INTO public.operation VALUES (12, 'Nettoyage injection', '3.00', 14);
INSERT INTO public.operation VALUES (13, 'Nettoyage vanne EGR', '2.00', 15);
INSERT INTO public.operation VALUES (14, 'Peinture portière / pare-chocs', '5.00', 16);
INSERT INTO public.operation VALUES (15, 'Peinture complète', '10.00', 17);
INSERT INTO public.operation VALUES (18, 'Démarreur', '2.00', 15);
INSERT INTO public.operation VALUES (16, 'Vidange boîte mécanique', '1.00', 15);
INSERT INTO public.operation VALUES (17, 'Vidange boîte automatique', '1.00', 18);
INSERT INTO public.operation VALUES (19, 'Gonfler pneus', '0.30', 14);


--
-- Data for Name: operator; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.operator VALUES ('viard', 'paul', 'viardpa', 'viardpa', 'operator');
INSERT INTO public.operator VALUES ('farret', 'Quentin', 'farretq', 'farretq', 'operator');
INSERT INTO public.operator VALUES ('durat', 'Mathias', 'duratm', 'duratm', 'chief');
INSERT INTO public.operator VALUES ('micoulet', 'alex', 'micoulea', 'micoulea', 'operator');
INSERT INTO public.operator VALUES ('lucci', 'Alain', 'luccia', 'luccia', 'operator');


--
-- Data for Name: planitem; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.planitem VALUES (4, 5, 5, 10);
INSERT INTO public.planitem VALUES (8, 6, 2, 5);
INSERT INTO public.planitem VALUES (7, 5, 5, 10);
INSERT INTO public.planitem VALUES (37, 1, 1, 3.4);
INSERT INTO public.planitem VALUES (48, 5, 1, 10);
INSERT INTO public.planitem VALUES (48, 12, 1, 99);


--
-- Data for Name: planope; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.planope VALUES (4, 14, 299, 5);
INSERT INTO public.planope VALUES (6, 2, 14, 2);
INSERT INTO public.planope VALUES (6, 11, 70, 3);
INSERT INTO public.planope VALUES (8, 16, 45, 1);
INSERT INTO public.planope VALUES (7, 15, 2450, 10);
INSERT INTO public.planope VALUES (48, 18, 23, 2);
INSERT INTO public.planope VALUES (48, 19, 45, 0.3);
INSERT INTO public.planope VALUES (48, 15, 145, 10);


--
-- Data for Name: tarif_mo; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.tarif_mo VALUES (10, 12);
INSERT INTO public.tarif_mo VALUES (11, 14);
INSERT INTO public.tarif_mo VALUES (12, 13);
INSERT INTO public.tarif_mo VALUES (13, 20);
INSERT INTO public.tarif_mo VALUES (14, 45);
INSERT INTO public.tarif_mo VALUES (16, 59);
INSERT INTO public.tarif_mo VALUES (17, 145);
INSERT INTO public.tarif_mo VALUES (15, 23);
INSERT INTO public.tarif_mo VALUES (18, 70);


--
-- Data for Name: useitem; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.useitem VALUES (6, 2, 5, 8);
INSERT INTO public.useitem VALUES (5, 5, 10, 7);
INSERT INTO public.useitem VALUES (1, 1, 3.4, 37);
INSERT INTO public.useitem VALUES (5, 5, 10, 4);
INSERT INTO public.useitem VALUES (5, 1, 10, 48);
INSERT INTO public.useitem VALUES (12, 1, 99, 48);


--
-- Data for Name: vehicle; Type: TABLE DATA; Schema: public; Owner: garagesports
--

INSERT INTO public.vehicle VALUES ('FB-473-HG', 'WVWF10604AT004437', '2012-05-11', 26, 12, true);
INSERT INTO public.vehicle VALUES ('HJ-663-IE', 'FFWH37D2J289NDJ13', '2005-02-11', 8, 13, true);
INSERT INTO public.vehicle VALUES ('KE-883-AN', 'FFWH37DN3893JE113', '2017-12-11', 18, 13, true);
INSERT INTO public.vehicle VALUES ('HE-371-JK', 'WBWJA2773H237112H', '2015-06-12', 7, 18, true);
INSERT INTO public.vehicle VALUES ('GF-531-HE', 'EJ388JH37K19SJ283J1', '2012-12-11', 18, 19, true);
INSERT INTO public.vehicle VALUES ('FT-623-XD', '2', '2003-12-23', 17, 15, true);
INSERT INTO public.vehicle VALUES ('ER-778-GT', '12', '2022-12-26', 7, 21, true);
INSERT INTO public.vehicle VALUES ('AB-568-ML', 'ML456FDFE745FD5G5', '2016-02-16', 2, 13, true);
INSERT INTO public.vehicle VALUES ('XB-344-HA', '3JD71KSD83JD73J8K', '2012-07-04', 5, 9, true);
INSERT INTO public.vehicle VALUES ('AX-123-DF', 'ddzsd', '2023-11-12', 1, 15, false);
INSERT INTO public.vehicle VALUES ('AQ-919-PE', 'J3BD8QK10KE8N17WH', '2011-02-25', 17, 9, true);
INSERT INTO public.vehicle VALUES ('BJ-663-AH', 'HFD72J1893HJ1002J', '2012-01-23', 3, 12, true);
INSERT INTO public.vehicle VALUES ('ZZ-488-XX', '3JN383NOKE3KLIAE4', '2019-01-26', 20, 9, true);
INSERT INTO public.vehicle VALUES ('ER-778-GK', '1J2J2JHJHDJHJDH2J', '2022-12-26', 3, 21, true);
INSERT INTO public.vehicle VALUES ('XX-799-KC', '3JN387NOKE3XLIAE4', '2017-06-02', 22, 9, true);
INSERT INTO public.vehicle VALUES ('XZ-919-KE', 'ADHDZJ773HZJD828J', '2010-11-21', 3, 12, true);
INSERT INTO public.vehicle VALUES ('AX-999-FG', 'JEUFUZJDOZUDKEIDJ', '2023-01-06', 6, 9, true);
INSERT INTO public.vehicle VALUES ('AZ-236-ER', 'FDZZDZDZAZERTYUIO', '1983-01-01', 23, 9, true);
INSERT INTO public.vehicle VALUES ('AQ-919-TE', 'AAZZEDREZAAEDDFRE', '2010-01-01', 12, 9, true);
INSERT INTO public.vehicle VALUES ('BV185HT', 'ZDUN433IHO2535JI5', '2002-04-05', 9, 18, true);
INSERT INTO public.vehicle VALUES ('XF-373-EJ', 'EJ2J18DJ289DH29DFN', '2012-06-14', 2, 9, false);


--
-- Name: askforintervention_numdde_seq; Type: SEQUENCE SET; Schema: public; Owner: garagesports
--

SELECT pg_catalog.setval('public.askforintervention_numdde_seq', 54, true);


--
-- Name: customer_customerid_seq; Type: SEQUENCE SET; Schema: public; Owner: garagesports
--

SELECT pg_catalog.setval('public.customer_customerid_seq', 24, true);


--
-- Name: tarif_mo_codetarif_seq; Type: SEQUENCE SET; Schema: public; Owner: garagesports
--

SELECT pg_catalog.setval('public.tarif_mo_codetarif_seq', 18, true);


--
-- Name: askforintervention askforintervention_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention
    ADD CONSTRAINT askforintervention_pkey PRIMARY KEY (numdde);


--
-- Name: bill bill_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.bill
    ADD CONSTRAINT bill_pkey PRIMARY KEY (billnum);


--
-- Name: brand brand_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.brand
    ADD CONSTRAINT brand_pkey PRIMARY KEY (numbrand);


--
-- Name: customer customer_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.customer
    ADD CONSTRAINT customer_pkey PRIMARY KEY (customerid);


--
-- Name: item item_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.item
    ADD CONSTRAINT item_pkey PRIMARY KEY (itemid);


--
-- Name: madeope madeope_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.madeope
    ADD CONSTRAINT madeope_pkey PRIMARY KEY (numdde, codeope);


--
-- Name: model model_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.model
    ADD CONSTRAINT model_pkey PRIMARY KEY (nummodel);


--
-- Name: operation operation_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.operation
    ADD CONSTRAINT operation_pkey PRIMARY KEY (codeope);


--
-- Name: operator operator_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.operator
    ADD CONSTRAINT operator_pkey PRIMARY KEY (login);


--
-- Name: useitem pkey_numddeiditem; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.useitem
    ADD CONSTRAINT pkey_numddeiditem PRIMARY KEY (numdde, itemid);


--
-- Name: planitem planitem_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planitem
    ADD CONSTRAINT planitem_pkey PRIMARY KEY (numdde, itemid);


--
-- Name: planope prevoirope_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planope
    ADD CONSTRAINT prevoirope_pkey PRIMARY KEY (numdde, codeope);


--
-- Name: tarif_mo tarif_mo_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.tarif_mo
    ADD CONSTRAINT tarif_mo_pkey PRIMARY KEY (codetarif);


--
-- Name: vehicle vehicle_pkey; Type: CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.vehicle
    ADD CONSTRAINT vehicle_pkey PRIMARY KEY (noimmat);


--
-- Name: planitem askforintervention; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planitem
    ADD CONSTRAINT askforintervention FOREIGN KEY (numdde) REFERENCES public.askforintervention(numdde);


--
-- Name: askforintervention askforintervention_customerid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention
    ADD CONSTRAINT askforintervention_customerid_fkey FOREIGN KEY (customerid) REFERENCES public.customer(customerid);


--
-- Name: askforintervention askforintervention_operatorlogin_fkey; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention
    ADD CONSTRAINT askforintervention_operatorlogin_fkey FOREIGN KEY (operatorlogin) REFERENCES public.operator(login);


--
-- Name: planope fk_codeope; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planope
    ADD CONSTRAINT fk_codeope FOREIGN KEY (codeope) REFERENCES public.operation(codeope);


--
-- Name: vehicle fk_customerid; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.vehicle
    ADD CONSTRAINT fk_customerid FOREIGN KEY (customerid) REFERENCES public.customer(customerid);


--
-- Name: askforintervention fk_immat; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention
    ADD CONSTRAINT fk_immat FOREIGN KEY (vehicleimmat) REFERENCES public.vehicle(noimmat);


--
-- Name: model fk_numbrand; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.model
    ADD CONSTRAINT fk_numbrand FOREIGN KEY (numbrand) REFERENCES public.brand(numbrand);


--
-- Name: planope fk_numdde; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planope
    ADD CONSTRAINT fk_numdde FOREIGN KEY (numdde) REFERENCES public.askforintervention(numdde);


--
-- Name: vehicle fk_nummodel; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.vehicle
    ADD CONSTRAINT fk_nummodel FOREIGN KEY (nummodel) REFERENCES public.model(nummodel);


--
-- Name: askforintervention fkey_billnum; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.askforintervention
    ADD CONSTRAINT fkey_billnum FOREIGN KEY (billnum) REFERENCES public.bill(billnum);


--
-- Name: madeope fkey_codeope; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.madeope
    ADD CONSTRAINT fkey_codeope FOREIGN KEY (codeope) REFERENCES public.operation(codeope);


--
-- Name: madeope fkey_numdde; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.madeope
    ADD CONSTRAINT fkey_numdde FOREIGN KEY (numdde) REFERENCES public.askforintervention(numdde);


--
-- Name: useitem fkey_numdde; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.useitem
    ADD CONSTRAINT fkey_numdde FOREIGN KEY (numdde) REFERENCES public.askforintervention(numdde);


--
-- Name: planitem item; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.planitem
    ADD CONSTRAINT item FOREIGN KEY (itemid) REFERENCES public.item(itemid);


--
-- Name: operation operation_codetarif_fkey; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.operation
    ADD CONSTRAINT operation_codetarif_fkey FOREIGN KEY (codetarif) REFERENCES public.tarif_mo(codetarif);


--
-- Name: useitem useitem; Type: FK CONSTRAINT; Schema: public; Owner: garagesports
--

ALTER TABLE ONLY public.useitem
    ADD CONSTRAINT useitem FOREIGN KEY (itemid) REFERENCES public.item(itemid);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: garagesports
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- PostgreSQL database dump complete
--

