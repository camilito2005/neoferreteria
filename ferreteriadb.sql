CREATE TABLE `categories` (
	`id` bigint(20) NOT NULL,
	`categoria_producto` varchar(100) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `clientes_neos` (
	`id` int(11) NOT NULL,
	`nombre` varchar(255) NOT NULL,
	`identificador` varchar(255) NOT NULL,
	`estado` tinyint(1) NOT NULL DEFAULT 'charsetutf8mb4'
);

CREATE TABLE `dafs` (
	`id` int(11) NOT NULL,
	`daf` FLOAT NOT NULL,
	`dafventa` FLOAT NOT NULL,
	`daftotal` FLOAT NOT NULL,
	`id_dd` int(11) NOT NULL,
	`iden_dd` varchar(190) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `detalle_facturas` (
	`id` int(11) NOT NULL,
	`idreferencia` varchar(255) NOT NULL,
	`idproducto` int(11) NOT NULL,
	`nombreproducto` varchar(255) NOT NULL,
	`cantidad` int(11) NOT NULL,
	`preciou` FLOAT NOT NULL,
	`total` FLOAT NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `facturas` (
	`id` int(11) NOT NULL,
	`referencia` varchar(255) NOT NULL,
	`empleadoatendio` varchar(255) NOT NULL,
	`fechaventa` DATE NOT NULL,
	`totalventa` FLOAT NOT NULL,
	`iddetalles` varchar(244) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `failed_jobs` (
	`id` bigint(20) NOT NULL,
	`uuid` varchar(100) NOT NULL,
	`connection` TEXT NOT NULL,
	`queue` TEXT NOT NULL,
	`payload` longtext NOT NULL,
	`exception` longtext NOT NULL,
	`failed_at` TIMESTAMP NOT NULL DEFAULT 'current_timestamp'
);

CREATE TABLE `mensajes` (
	`id` int(11) NOT NULL,
	`mensaje` varchar(255) NOT NULL,
	`de_nombre` varchar(255) NOT NULL,
	`de_id` int(11) NOT NULL,
	`para_nombre` varchar(255) NOT NULL,
	`para_id` int(11) NOT NULL,
	`created_at` varchar(255) NOT NULL,
	`updated_at` varchar(255) NOT NULL DEFAULT 'charsetutf8mb4'
);

CREATE TABLE `migrations` (
	`id` int(10) NOT NULL,
	`migration` varchar(191) NOT NULL,
	`batch` int(11) NOT NULL DEFAULT 'charsetutf8mb4'
);

CREATE TABLE `password_resets` (
	`email` varchar(191) NOT NULL,
	`token` varchar(191) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `password_reset_tokens` (
	`email` varchar(100) NOT NULL,
	`token` varchar(191) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `personal_access_tokens` (
	`id` bigint(20) NOT NULL,
	`tokenable_type` varchar(191) NOT NULL,
	`tokenable_id` bigint(20) NOT NULL,
	`name` varchar(100) NOT NULL,
	`token` varchar(100) NOT NULL,
	`abilities` TEXT NOT NULL DEFAULT 'null',
	`last_used_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`expires_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `productos` (
	`id` bigint(20) NOT NULL,
	`identificador` varchar(255) NOT NULL,
	`referencia` varchar(255) NOT NULL,
	`nombre` varchar(100) NOT NULL,
	`marca` varchar(255) NOT NULL,
	`descripcion` varchar(255) NOT NULL,
	`categoria_producto` varchar(100) NOT NULL,
	`precio` double(83) NOT NULL,
	`stock` int(11) NOT NULL,
	`daftp` FLOAT NOT NULL,
	`imagen` varchar(191) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `proveedors` (
	`id` bigint(20) NOT NULL,
	`nombre` varchar(100) NOT NULL,
	`direccion` varchar(100) NOT NULL,
	`numero` int(11) NOT NULL,
	`correo` varchar(100) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `users` (
	`id` bigint(20) NOT NULL,
	`name` varchar(191) NOT NULL,
	`email` varchar(100) NOT NULL,
	`rol` varchar(200) NOT NULL,
	`identificador` varchar(255) NOT NULL,
	`email_verified_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`password` varchar(191) NOT NULL,
	`remember_token` varchar(100) NOT NULL DEFAULT 'null',
	`created_at` TIMESTAMP NOT NULL DEFAULT 'null',
	`updated_at` TIMESTAMP NOT NULL DEFAULT 'null'
);

CREATE TABLE `usuarios_empleados` (
	`id` int(11) NOT NULL,
	`nombre_admin` varchar(255) NOT NULL,
	`nombre_empleado` varchar(255) NOT NULL,
	`identificador_admin` varchar(255) NOT NULL,
	`estado` varchar(255) NOT NULL,
	`created_at` varchar(255) NOT NULL,
	`updated_at` varchar(255) NOT NULL DEFAULT 'charsetutf8mb4'
);

CREATE TABLE `venta_facturacions` (
	`id` int(11) NOT NULL,
	`identificador` varchar(255) NOT NULL,
	`producto` varchar(255) NOT NULL,
	`cantidad_vendida` varchar(255) NOT NULL,
	`preciou` varchar(255) NOT NULL,
	`total` FLOAT NOT NULL DEFAULT 'charsetutf8mb4',
	PRIMARY KEY (`total`)
);

ALTER TABLE `clientes_neos` ADD CONSTRAINT `clientes_neos_fk0` FOREIGN KEY (`identificador`) REFERENCES `usuarios_empleados`(`identificador_admin`);

ALTER TABLE `dafs` ADD CONSTRAINT `dafs_fk0` FOREIGN KEY (`iden_dd`) REFERENCES `clientes_neos`(`identificador`);

ALTER TABLE `facturas` ADD CONSTRAINT `facturas_fk0` FOREIGN KEY (`referencia`) REFERENCES `detalle_facturas`(`idreferencia`);

ALTER TABLE `facturas` ADD CONSTRAINT `facturas_fk1` FOREIGN KEY (`empleadoatendio`) REFERENCES `usuarios_empleados`(`nombre_empleado`);

ALTER TABLE `mensajes` ADD CONSTRAINT `mensajes_fk0` FOREIGN KEY (`de_id`) REFERENCES `users`(`id`);

ALTER TABLE `mensajes` ADD CONSTRAINT `mensajes_fk1` FOREIGN KEY (`para_id`) REFERENCES `usuarios_empleados`(`id`);

ALTER TABLE `productos` ADD CONSTRAINT `productos_fk0` FOREIGN KEY (`identificador`) REFERENCES `clientes_neos`(`identificador`);

ALTER TABLE `productos` ADD CONSTRAINT `productos_fk1` FOREIGN KEY (`referencia`) REFERENCES `facturas`(`referencia`);

ALTER TABLE `productos` ADD CONSTRAINT `productos_fk2` FOREIGN KEY (`categoria_producto`) REFERENCES `categories`(`categoria_producto`);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`identificador`) REFERENCES `clientes_neos`(`identificador`);

















