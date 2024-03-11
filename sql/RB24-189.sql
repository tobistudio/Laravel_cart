INSERT INTO rb24.backend_menu_items (id, type, parent_id, icon, name, link, `order`, disabled, allow_permission, created_at, updated_at)
VALUES (23, 'sidebar', 10, 'dot', 'shop_attributes', '/system/shop/attributes', 9, 0, 1, '2024-01-18 13:52:17', '2024-01-18 13:52:19');

create table attributes
(
    id         bigint unsigned auto_increment,
    type       int             not null,
    created_at timestamp NULL  DEFAULT NULL,
    updated_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP,
    constraint attributes_pk
        primary key (id)
);

create table attribute_titles
(
    id           bigint   unsigned auto_increment,
    attribute_id bigint   unsigned not null,
    language_id  smallint unsigned not null,
    value        varchar(250)     not null,
    created_at timestamp NULL  DEFAULT NULL,
    updated_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP,
    constraint attribute_titles_pk
        primary key (id),
    constraint attribute_titles_attributes_id_fk
        foreign key (attribute_id) references attributes (id) on delete cascade,
    constraint attribute_titles_languages_id_fk
        foreign key (language_id) references languages (id)
);

create table attribute_title_values
(
    id                 bigint   unsigned auto_increment,
    attribute_title_id bigint   unsigned not null,
    value              varchar(250)    not null,
    created_at         timestamp NULL  DEFAULT NULL,
    updated_at         timestamp NULL  DEFAULT CURRENT_TIMESTAMP,
    constraint attributes_pk
        primary key (id),
    constraint attribute_values_attributes_id_fk
        foreign key (attribute_title_id) references attribute_titles (id) on delete cascade
);

create table product_attributes
(
    id           bigint unsigned auto_increment,
    attribute_id bigint unsigned not null,
    product_id   bigint unsigned not null,
    created_at   timestamp NULL  DEFAULT NULL,
    updated_at   timestamp NULL  DEFAULT CURRENT_TIMESTAMP,
    constraint product_attributes_pk
        primary key (id),
    constraint product_attributes_language_pages_id_fk
        foreign key (product_id) references language_pages (id)
);
