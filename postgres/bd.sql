/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     02.05.2024 13:17:34                          */
/*==============================================================*/




/*==============================================================*/
/* Table: booking                                               */
/*==============================================================*/
create table booking (
   id_booking           SERIAL               not null,
   id_manager           INT4                 not null,
   date_application     DATE                 not null,
   status_booking       VARCHAR(20)          null,
   date_close           DATE                 null,
   constraint PK_BOOKING primary key (id_booking)
);

/*==============================================================*/
/* Index: booking_PK                                            */
/*==============================================================*/
create unique index booking_PK on booking (
id_booking
);

/*==============================================================*/
/* Index: is_included_FK                                        */
/*==============================================================*/
create  index is_included_FK on booking (
id_manager
);

/*==============================================================*/
/* Table: client                                                */
/*==============================================================*/
create table client (
   id_client            SERIAL               not null,
   full_name_client     VARCHAR(100)         not null,
   phone_client         VARCHAR(15)          not null,
   login_client         VARCHAR(30)          not null,
   password_client      VARCHAR(100)         not null,
   constraint PK_CLIENT primary key (id_client)
);

/*==============================================================*/
/* Index: client_PK                                             */
/*==============================================================*/
create unique index client_PK on client (
id_client
);

/*==============================================================*/
/* Table: client_equipment                                      */
/*==============================================================*/
create table client_equipment (
   id_equip             SERIAL               not null,
   id_client            INT4                 not null,
   name_equip           VARCHAR(100)         not null,
   serial_number_equip  VARCHAR(100)         not null,
   desc_equip           VARCHAR(2500)        not null,
   constraint PK_CLIENT_EQUIPMENT primary key (id_equip)
);

/*==============================================================*/
/* Index: client_equipment_PK                                   */
/*==============================================================*/
create unique index client_equipment_PK on client_equipment (
id_equip
);

/*==============================================================*/
/* Index: has_FK                                                */
/*==============================================================*/
create  index has_FK on client_equipment (
id_client
);

/*==============================================================*/
/* Table: details                                               */
/*==============================================================*/
create table details (
   id_detail            SERIAL               not null,
   amount_detail        INT4                 not null,
   name_detail          VARCHAR(100)         not null,
   price_detail         FLOAT8               not null,
   constraint PK_DETAILS primary key (id_detail)
);

/*==============================================================*/
/* Index: details_PK                                            */
/*==============================================================*/
create unique index details_PK on details (
id_detail
);

/*==============================================================*/
/* Table: included_in                                           */
/*==============================================================*/
create table included_in (
   id_booking           INT4                 not null,
   id_equip             INT4                 not null,
   constraint PK_INCLUDED_IN primary key (id_booking, id_equip)
);

/*==============================================================*/
/* Index: included_in_PK                                        */
/*==============================================================*/
create unique index included_in_PK on included_in (
id_booking,
id_equip
);

/*==============================================================*/
/* Index: included_in2_FK                                       */
/*==============================================================*/
create  index included_in2_FK on included_in (
id_equip
);

/*==============================================================*/
/* Index: included_in_FK                                        */
/*==============================================================*/
create  index included_in_FK on included_in (
id_booking
);

/*==============================================================*/
/* Table: manager                                               */
/*==============================================================*/
create table manager (
   id_manager           SERIAL               not null,
   full_name_manager    VARCHAR(100)         not null,
   phone_manager        VARCHAR(15)          not null,
   birth_manager        DATE                 not null,
   login_manager        VARCHAR(30)          not null,
   password_manager     VARCHAR(100)         not null,
   constraint PK_MANAGER primary key (id_manager)
);

/*==============================================================*/
/* Index: manager_PK                                            */
/*==============================================================*/
create unique index manager_PK on manager (
id_manager
);

/*==============================================================*/
/* Table: provided_service                                      */
/*==============================================================*/
create table provided_service (
   id_provided_serive   SERIAL               not null,
   id_service           INT4                 not null,
   id_worker            INT4                 not null,
   id_booking           INT4                 null,
   amount_provided_service INT4                 not null,
   constraint PK_PROVIDED_SERVICE primary key (id_provided_serive)
);

/*==============================================================*/
/* Index: provided_service_PK                                   */
/*==============================================================*/
create unique index provided_service_PK on provided_service (
id_provided_serive
);

/*==============================================================*/
/* Index: also_implies_FK                                       */
/*==============================================================*/
create  index also_implies_FK on provided_service (
id_service
);

/*==============================================================*/
/* Index: provide_FK                                            */
/*==============================================================*/
create  index provide_FK on provided_service (
id_worker
);

/*==============================================================*/
/* Index: also_includes_FK                                      */
/*==============================================================*/
create  index also_includes_FK on provided_service (
id_booking
);

/*==============================================================*/
/* Table: service                                               */
/*==============================================================*/
create table service (
   id_service           SERIAL               not null,
   name_service         VARCHAR(100)         not null,
   price_service        FLOAT8               not null,
   constraint PK_SERVICE primary key (id_service)
);

/*==============================================================*/
/* Index: service_PK                                            */
/*==============================================================*/
create unique index service_PK on service (
id_service
);

/*==============================================================*/
/* Table: used_details                                          */
/*==============================================================*/
create table used_details (
   id_used_detail       SERIAL               not null,
   id_detail            INT4                 null,
   id_booking           INT4                 null,
   amount_used_detals   INT4                 not null,
   constraint PK_USED_DETAILS primary key (id_used_detail)
);

/*==============================================================*/
/* Index: used_details_PK                                       */
/*==============================================================*/
create unique index used_details_PK on used_details (
id_used_detail
);

/*==============================================================*/
/* Index: implies_FK                                            */
/*==============================================================*/
create  index implies_FK on used_details (
id_detail
);

/*==============================================================*/
/* Index: includes_FK                                           */
/*==============================================================*/
create  index includes_FK on used_details (
id_booking
);

/*==============================================================*/
/* Table: worker                                                */
/*==============================================================*/
create table worker (
   id_worker            SERIAL               not null,
   full_name_worker     VARCHAR(70)          not null,
   phone_worker         VARCHAR(15)          not null,
   birth_worker         DATE                 not null,
   login_worker         VARCHAR(30)          not null,
   password_worker      VARCHAR(100)         not null,
   constraint PK_WORKER primary key (id_worker)
);

/*==============================================================*/
/* Index: worker_PK                                             */
/*==============================================================*/
create unique index worker_PK on worker (
id_worker
);

alter table booking
   add constraint FK_BOOKING_IS_INCLUD_MANAGER foreign key (id_manager)
      references manager (id_manager)
      on delete restrict on update restrict;

alter table client_equipment
   add constraint FK_CLIENT_E_HAS_CLIENT foreign key (id_client)
      references client (id_client)
      on delete restrict on update restrict;

alter table included_in
   add constraint FK_INCLUDED_INCLUDED__BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

alter table included_in
   add constraint FK_INCLUDED_INCLUDED__CLIENT_E foreign key (id_equip)
      references client_equipment (id_equip)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_ALSO_IMPL_SERVICE foreign key (id_service)
      references service (id_service)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_ALSO_INCL_BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_PROVIDE_WORKER foreign key (id_worker)
      references worker (id_worker)
      on delete restrict on update restrict;

alter table used_details
   add constraint FK_USED_DET_IMPLIES_DETAILS foreign key (id_detail)
      references details (id_detail)
      on delete restrict on update restrict;

alter table used_details
   add constraint FK_USED_DET_INCLUDES_BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

