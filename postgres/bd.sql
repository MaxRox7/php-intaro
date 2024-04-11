

/*==============================================================*/
/* Table: booking                                               */
/*==============================================================*/
create table booking (
   id_booking           SERIAL               not null,
   id_client            INT4                 not null,
   id_manager           INT4                 not null,
   id_bill              INT4                 null,
   date_request         DATE                 not null,
   status_booking       VARCHAR(10)          null,
   booking_close_date   DATE                 not null,
   constraint PK_BOOKING primary key (id_booking)
);

/*==============================================================*/
/* Index: booking_PK                                            */
/*==============================================================*/
create unique index booking_PK on booking (
id_booking
);

/*==============================================================*/
/* Index: making_FK                                             */
/*==============================================================*/
create  index making_FK on booking (
id_client
);

/*==============================================================*/
/* Index: places_FK                                             */
/*==============================================================*/
create  index places_FK on booking (
id_manager
);

/*==============================================================*/
/* Index: includes_FK                                           */
/*==============================================================*/
create  index includes_FK on booking (

);

/*==============================================================*/
/* Table: client                                                */
/*==============================================================*/
create table client (
   fn_client            VARCHAR(70)          not null,
   number_client        VARCHAR(10)          not null,
   id_client            SERIAL               not null,
   id_user              INT4                 not null,
   constraint PK_CLIENT primary key (id_client)
);

/*==============================================================*/
/* Index: client_PK                                             */
/*==============================================================*/
create unique index client_PK on client (
id_client
);

/*==============================================================*/
/* Index: for_auth4_FK                                          */
/*==============================================================*/
create  index for_auth4_FK on client (
id_user
);

/*==============================================================*/
/* Table: client_equip                                          */
/*==============================================================*/
create table client_equip (
   id_equip             SERIAL               not null,
   id_client            INT4                 not null,
   name_equip           VARCHAR(50)          not null,
   sn_equip             VARCHAR(30)          not null,
   description_equip    TEXT                 not null,
   constraint PK_CLIENT_EQUIP primary key (id_equip)
);

/*==============================================================*/
/* Index: client_equip_PK                                       */
/*==============================================================*/
create unique index client_equip_PK on client_equip (
id_equip
);

/*==============================================================*/
/* Index: has_FK                                                */
/*==============================================================*/
create  index has_FK on client_equip (
id_client
);

/*==============================================================*/
/* Table: details                                               */
/*==============================================================*/
create table details (
   id_detai             SERIAL               not null,
   amount_detail        INT4                 not null,
   name_detail          VARCHAR(100)         not null,
   price_detail         MONEY                not null,
   constraint PK_DETAILS primary key (id_detai)
);

/*==============================================================*/
/* Index: details_PK                                            */
/*==============================================================*/
create unique index details_PK on details (
id_detai
);

/*==============================================================*/
/* Table: included                                              */
/*==============================================================*/
create table included (
   id_booking           INT4                 not null,
   id_equip             INT4                 not null,
   constraint PK_INCLUDED primary key (id_booking, id_equip)
);

/*==============================================================*/
/* Index: included_PK                                           */
/*==============================================================*/
create unique index included_PK on included (
id_booking,
id_equip
);

/*==============================================================*/
/* Index: included2_FK                                          */
/*==============================================================*/
create  index included2_FK on included (
id_equip
);

/*==============================================================*/
/* Index: included_FK                                           */
/*==============================================================*/
create  index included_FK on included (
id_booking
);

/*==============================================================*/
/* Table: manager                                               */
/*==============================================================*/
create table manager (
   id_manager           SERIAL               not null,
   id_user              INT4                 not null,
   fn_managed           VARCHAR(70)          not null,
   number_managed       VARCHAR(10)          not null,
   birth_manager        DATE                 not null,
   constraint PK_MANAGER primary key (id_manager)
);

/*==============================================================*/
/* Index: manager_PK                                            */
/*==============================================================*/
create unique index manager_PK on manager (
id_manager
);

/*==============================================================*/
/* Index: for_auth6_FK                                          */
/*==============================================================*/
create  index for_auth6_FK on manager (
id_user
);

/*==============================================================*/
/* Table: provided_service                                      */
/*==============================================================*/
create table provided_service (
   amount_service_provided INT4                 not null,
   od_provoded_service  SERIAL               not null,
   id_service           INT4                 not null,
   id_worker            INT4                 not null,
   id_booking           INT4                 null,
   constraint PK_PROVIDED_SERVICE primary key (od_provoded_service)
);

/*==============================================================*/
/* Index: provided_service_PK                                   */
/*==============================================================*/
create unique index provided_service_PK on provided_service (
od_provoded_service
);

/*==============================================================*/
/* Index: provide_from_FK                                       */
/*==============================================================*/
create  index provide_from_FK on provided_service (
id_service
);

/*==============================================================*/
/* Index: provide_FK                                            */
/*==============================================================*/
create  index provide_FK on provided_service (
id_worker
);

/*==============================================================*/
/* Index: included_in_FK                                        */
/*==============================================================*/
create  index included_in_FK on provided_service (
id_booking
);

/*==============================================================*/
/* Table: service                                               */
/*==============================================================*/
create table service (
   id_service           SERIAL               not null,
   name_service         VARCHAR(20)          not null,
   price_service        MONEY                not null,
   constraint PK_SERVICE primary key (id_service)
);

/*==============================================================*/
/* Index: service_PK                                            */
/*==============================================================*/
create unique index service_PK on service (
id_service
);

/*==============================================================*/
/* Table: used_detail                                           */
/*==============================================================*/
create table used_detail (
   id_used_detail       SERIAL               not null,
   id_detai             INT4                 null,
   id_booking           INT4                 null,
   amount_used_detail   INT4                 not null,
   constraint PK_USED_DETAIL primary key (id_used_detail)
);

/*==============================================================*/
/* Index: used_detail_PK                                        */
/*==============================================================*/
create unique index used_detail_PK on used_detail (
id_used_detail
);

/*==============================================================*/
/* Index: consists_of_FK                                        */
/*==============================================================*/
create  index consists_of_FK on used_detail (
id_detai
);

/*==============================================================*/
/* Index: is_in_FK                                              */
/*==============================================================*/
create  index is_in_FK on used_detail (
id_booking
);

/*==============================================================*/
/* Table: "user"                                                */
/*==============================================================*/
create table "user" (
   id_user              SERIAL               not null,
   login                VARCHAR(255)         null,
   password             VARCHAR(255)         null,
   constraint PK_USER primary key (id_user)
);

/*==============================================================*/
/* Index: user_PK                                               */
/*==============================================================*/
create unique index user_PK on "user" (
id_user
);

/*==============================================================*/
/* Table: worker                                                */
/*==============================================================*/
create table worker (
   id_worker            SERIAL               not null,
   id_user              INT4                 not null,
   fn_worker            VARCHAR(70)          not null,
   number_worker        VARCHAR(10)          not null,
   birth_worker         DATE                 not null,
   constraint PK_WORKER primary key (id_worker)
);

/*==============================================================*/
/* Index: worker_PK                                             */
/*==============================================================*/
create unique index worker_PK on worker (
id_worker
);

/*==============================================================*/
/* Index: for_auth5_FK                                          */
/*==============================================================*/
create  index for_auth5_FK on worker (
id_user
);

alter table booking
   add constraint FK_BOOKING_MAKING_CLIENT foreign key (id_client)
      references client (id_client)
      on delete restrict on update restrict;

alter table booking
   add constraint FK_BOOKING_PLACES_MANAGER foreign key (id_manager)
      references manager (id_manager)
      on delete restrict on update restrict;

alter table client
   add constraint FK_CLIENT_FOR_AUTH4_USER foreign key (id_user)
      references "user" (id_user)
      on delete restrict on update restrict;

alter table client_equip
   add constraint FK_CLIENT_E_HAS_CLIENT foreign key (id_client)
      references client (id_client)
      on delete restrict on update restrict;

alter table included
   add constraint FK_INCLUDED_INCLUDED_BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

alter table included
   add constraint FK_INCLUDED_INCLUDED2_CLIENT_E foreign key (id_equip)
      references client_equip (id_equip)
      on delete restrict on update restrict;

alter table manager
   add constraint FK_MANAGER_FOR_AUTH6_USER foreign key (id_user)
      references "user" (id_user)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_INCLUDED__BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_PROVIDE_WORKER foreign key (id_worker)
      references worker (id_worker)
      on delete restrict on update restrict;

alter table provided_service
   add constraint FK_PROVIDED_PROVIDE_F_SERVICE foreign key (id_service)
      references service (id_service)
      on delete restrict on update restrict;

alter table used_detail
   add constraint FK_USED_DET_CONSISTS__DETAILS foreign key (id_detai)
      references details (id_detai)
      on delete restrict on update restrict;

alter table used_detail
   add constraint FK_USED_DET_IS_IN_BOOKING foreign key (id_booking)
      references booking (id_booking)
      on delete restrict on update restrict;

alter table worker
   add constraint FK_WORKER_FOR_AUTH5_USER foreign key (id_user)
      references "user" (id_user)
      on delete restrict on update restrict;
