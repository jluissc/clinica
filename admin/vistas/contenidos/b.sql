-- -----------------------------------------------------
-- Table `clinica_db3`.`tipo_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`tipo_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`persona` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `apellidos` VARCHAR(45) NULL DEFAULT NULL,
  `dni` INT(8) NULL DEFAULT NULL,
  `celular` VARCHAR(15) NULL DEFAULT NULL,
  `correo` VARCHAR(25) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  `foto` VARCHAR(45) NULL DEFAULT NULL,
  `user` VARCHAR(45) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `tipo_user_id` INT(11) NOT NULL,
  `estado` INT(1) NOT NULL,
  `logueo` INT(1) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`tipo_user_id`)
    REFERENCES `clinica_db3`.`tipo_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`tipo_servicio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`tipo_servicio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `estado` INT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`servicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `precio_normal` DECIMAL(6,2) NULL DEFAULT NULL,
  `precio_venta` DECIMAL(6,2) NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `tipo_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`tipo_id`)
    REFERENCES `clinica_db3`.`tipo_servicio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`tipo_cita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`tipo_cita` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `precio` VARCHAR(45) NULL,
  `estado` INT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`horas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`horas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `hora` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`citas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`citas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL DEFAULT NULL,
  `tiempo` INT(2) NULL DEFAULT NULL,
  `mensaje` TEXT NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `paciente_id` INT(11) NOT NULL,
  `producto_id` INT(11) NOT NULL,
  `tipo_cita_id` INT NOT NULL,
  `horas_id` INT NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`paciente_id`)
    REFERENCES `clinica_db3`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`producto_id`)
    REFERENCES `clinica_db3`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tipo_cita_id`)
    REFERENCES `clinica_db3`.`tipo_cita` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`horas_id`)
    REFERENCES `clinica_db3`.`horas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`cita_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`cita_detalle` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NULL DEFAULT NULL,
  `recetas` TEXT NULL DEFAULT NULL,
  `prohibicion` TEXT NULL DEFAULT NULL,
  `otros` VARCHAR(45) NULL DEFAULT NULL,
  `citas_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`citas_id`)
    REFERENCES `clinica_db3`.`citas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`sede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`sede` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `telefono` VARCHAR(15) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  `logo` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`horas_no_atencion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`horas_no_atencion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dia` DATE NULL,
  `horas_id` INT NOT NULL,
  `sede_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`sede_id`)
    REFERENCES `clinica_db3`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`horas_id`)
    REFERENCES `clinica_db3`.`horas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(45) NULL DEFAULT NULL,
  `servicios_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`servicios_id`)
    REFERENCES `clinica_db3`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`medico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`medico` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `experiencia` VARCHAR(45) NULL DEFAULT NULL,
  `especialidad` VARCHAR(45) NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`user_id`)
    REFERENCES `clinica_db3`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`empresa_id`)
    REFERENCES `clinica_db3`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`testimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`testimonio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `testimonio` TEXT NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`user_id`)
    REFERENCES `clinica_db3`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`cita_pagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`cita_pagos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nmr_transaccion` VARCHAR(45) NULL DEFAULT NULL,
  `medio_pago` VARCHAR(45) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `total` DECIMAL(6,2) NULL DEFAULT NULL,
  `estado` INT(2) NULL DEFAULT NULL,
  `citas_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`citas_id`)
    REFERENCES `clinica_db3`.`citas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`materiales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`materiales` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(95) NULL,
  `descripcion` TEXT NULL,
  `materialescol` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `clinica_db3`.`gastos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`gastos` (
  `id` INT NOT NULL,
  `materiales_id` INT NOT NULL,
  `precio` DECIMAL(11,2) NULL,
  `cantidad` INT NULL,
  `fecha` TIMESTAMP NULL,
  `persona_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`materiales_id`)
    REFERENCES `clinica_db3`.`materiales` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`persona_id`)
    REFERENCES `clinica_db3`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `clinica_db3`.`permisos_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`permisos_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `servicios` INT(1) NULL,
  `citas` INT(1) NULL,
  `gastos` INT(1) NULL,
  `pagos` INT(1) NULL,
  `materiales` INT(1) NULL,
  `persona_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`persona_id`)
    REFERENCES `clinica_db3`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db3`.`cita_no_atencion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db3`.`cita_no_atencion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dia` DATE NULL,
  `sede_id` INT(11) NOT NULL,
  `tipo_cita_id` INT NOT NULL, 
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`sede_id`)
    REFERENCES `clinica_db3`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tipo_cita_id`)
    REFERENCES `clinica_db3`.`tipo_cita` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;