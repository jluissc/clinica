CREATE TABLE IF NOT EXISTS `clinica_db6`.`tipo_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`persona` (
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
  `logueo` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
--   UNIQUE INDEX `dni` (`dni` ASC) VISIBLE,
    FOREIGN KEY (`tipo_user_id`)
    REFERENCES `clinica_db6`.`tipo_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`servicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `precio_normal` DECIMAL(6,2) NULL DEFAULT NULL,
  `precio_venta` DECIMAL(6,2) NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `tipo_id` INT(11) NOT NULL,
  `tiempo` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`horas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`horas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hora` VARCHAR(45) NULL DEFAULT NULL,
  `estado` INT(1) NOT NULL,
  `servicios_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`servicios_id`)
    REFERENCES `clinica_db6`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`tratamientos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`tratamientos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL DEFAULT NULL,
  `tiempo` INT(2) NULL DEFAULT NULL,
  `mensaje` TEXT NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `atentido` INT(1) NOT NULL,
  `paciente_id` INT(11) NOT NULL,
  `horas_id` INT(11) NOT NULL,
  `servicios_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`paciente_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`horas_id`)
    REFERENCES `clinica_db6`.`horas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`servicios_id`)
    REFERENCES `clinica_db6`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`cita_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`cita_detalle` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NULL DEFAULT NULL,
  `recetas` TEXT NULL DEFAULT NULL,
  `prohibicion` TEXT NULL DEFAULT NULL,
  `otros` VARCHAR(45) NULL DEFAULT NULL,
  `citas_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`citas_id`)
    REFERENCES `clinica_db6`.`tratamientos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`tipo_pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`tipo_pago` (
  `id` INT(1) NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`cita_pagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`cita_pagos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `detalles` VARCHAR(100) NOT NULL,
  `nmr_transaccion` VARCHAR(45) NULL DEFAULT NULL,
  `medio_pago` VARCHAR(45) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `total` DECIMAL(6,2) NULL DEFAULT NULL,
  `estado` INT(2) NULL DEFAULT NULL,
  `citas_id` INT(11) NOT NULL,
  `tipo_pago_id1` INT(1) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`citas_id`)
    REFERENCES `clinica_db6`.`tratamientos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tipo_pago_id1`)
    REFERENCES `clinica_db6`.`tipo_pago` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`materiales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`materiales` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(95) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`gastos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`gastos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `materiales_id` INT(11) NOT NULL,
  `precio` DECIMAL(11,2) NULL DEFAULT NULL,
  `cantidad` INT(11) NULL DEFAULT NULL,
  `fecha` TIMESTAMP NULL DEFAULT NULL,
  `persona_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`materiales_id`)
    REFERENCES `clinica_db6`.`materiales` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`persona_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(45) NULL DEFAULT NULL,
  `servicios_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`servicios_id`)
    REFERENCES `clinica_db6`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`sede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`sede` (
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
-- Table `clinica_db6`.`medico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`medico` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `experiencia` VARCHAR(45) NULL DEFAULT NULL,
  `especialidad` VARCHAR(45) NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `empresa_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`user_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`empresa_id`)
    REFERENCES `clinica_db6`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`permisos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`permisos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`permisos_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`permisos_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `persona_id` INT(11) NOT NULL,
  `permisos_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`persona_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`permisos_id`)
    REFERENCES `clinica_db6`.`permisos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`testimonio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`testimonio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `testimonio` TEXT NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`user_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`tipo_cita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`tipo_cita` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `precio` VARCHAR(45) NULL DEFAULT NULL,
  `estado` INT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`dias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`dias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`config` (
  `id` INT(1) NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`dias_hora_atencion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`dias_hora_atencion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dias_id` INT NOT NULL,
  `tipo_cita_id` INT(11) NOT NULL,
  `config_id` INT NOT NULL,
  `horainicio` TIME NULL,
  `horafin` TIME NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`dias_id`)
    REFERENCES `clinica_db6`.`dias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tipo_cita_id`)
    REFERENCES `clinica_db6`.`tipo_cita` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`config_id`)
    REFERENCES `clinica_db6`.`config` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`historial`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`historial` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NULL,
  `persona_id` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`persona_id`)
    REFERENCES `clinica_db6`.`persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `clinica_db6`.`historial_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`historial_detalle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `historial_id` INT NOT NULL,
  `tratamientos_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`historial_id`)
    REFERENCES `clinica_db6`.`historial` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tratamientos_id`)
    REFERENCES `clinica_db6`.`tratamientos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clinica_db6`.`servicios_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinica_db6`.`servicios_tipo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `servicios_id` INT(11) NOT NULL,
  `tipo_cita_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`), 
    FOREIGN KEY (`servicios_id`)
    REFERENCES `clinica_db6`.`servicios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    FOREIGN KEY (`tipo_cita_id`)
    REFERENCES `clinica_db6`.`tipo_cita` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;