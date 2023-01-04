SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `adam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `adam`;

-- -----------------------------------------------------
-- Table `adam`.`tipo_instrumento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`tipo_instrumento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `descripcion` TEXT NULL ,
  `code` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`fuente_de_datos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`fuente_de_datos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ip` TINYTEXT NOT NULL ,
  `usuario` TINYTEXT NOT NULL ,
  `clave` TINYTEXT NOT NULL ,
  `timeout` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`estacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`estacion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `adcon_id` INT NOT NULL ,
  `nombre` TINYTEXT NOT NULL ,
  `latitud` DOUBLE NOT NULL ,
  `longitud` DOUBLE NOT NULL ,
  `altura` DOUBLE NOT NULL ,
  `ultima_fecha` DATE NOT NULL ,
  `ultima_hora` TIME NOT NULL ,
  `intentos_de_descarga` INT NOT NULL DEFAULT 0 ,
  `estacion_clon_id` INT NULL DEFAULT 0 ,
  `estado` TINYTEXT NOT NULL COMMENT '[D] = Descargando\n[S] = Detenida\n[C] = En modo clonacion\n[O] = Offline\n[E] = Error Desconocido' ,
  `descargar` INT NOT NULL COMMENT '[1] = Si\n[0] = No' ,
  `clonar` INT NOT NULL COMMENT '[1] = Si\n[0] = No' ,
  `fuente_de_datos_id` INT NULL ,
  `ultima_fecha_clon` DATE NULL ,
  `ultima_hora_clon` TIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_estacion_fuente_de_datos` (`fuente_de_datos_id` ASC) ,
  CONSTRAINT `fk_estacion_fuente_de_datos`
    FOREIGN KEY (`fuente_de_datos_id` )
    REFERENCES `adam`.`fuente_de_datos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`responsable`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`responsable` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `telefono` TINYTEXT NULL ,
  `email` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`instrumento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`instrumento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `unidad` TINYTEXT NOT NULL ,
  `marca` TINYTEXT NULL ,
  `modelo` TINYTEXT NULL ,
  `adcon_id` INT NULL DEFAULT NULL COMMENT 'condicional, no obligatorio' ,
  `ubicacion_nombre` TEXT NULL ,
  `observacion` TEXT NULL ,
  `fecha_instalacion` DATE NULL ,
  `tipo_instrumento_id` INT NOT NULL ,
  `estacion_id` INT NULL DEFAULT NULL ,
  `responsable_id` INT NOT NULL ,
  `revisar_datos` INT NULL COMMENT '[1] = Revisar datos\n[0] = No revisar datos' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_instrumento_tipo_instrumento` (`tipo_instrumento_id` ASC) ,
  INDEX `fk_instrumento_estacion` (`estacion_id` ASC) ,
  INDEX `fk_instrumento_responsable` (`responsable_id` ASC) ,
  CONSTRAINT `fk_instrumento_tipo_instrumento`
    FOREIGN KEY (`tipo_instrumento_id` )
    REFERENCES `adam`.`tipo_instrumento` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_instrumento_estacion`
    FOREIGN KEY (`estacion_id` )
    REFERENCES `adam`.`estacion` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_instrumento_responsable`
    FOREIGN KEY (`responsable_id` )
    REFERENCES `adam`.`responsable` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;


-- -----------------------------------------------------
-- Table `adam`.`medicion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`medicion` (
  `fecha` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `medicion` DOUBLE NOT NULL ,
  `instrumento_id` INT NOT NULL ,
  INDEX `fk_medicion_instrumento` (`instrumento_id` ASC) ,
  PRIMARY KEY (`fecha`, `hora`, `instrumento_id`) ,
  UNIQUE INDEX `indice_clave` USING BTREE (`fecha` ASC, `hora` ASC, `instrumento_id` ASC) ,
  CONSTRAINT `fk_medicion_instrumento`
    FOREIGN KEY (`instrumento_id` )
    REFERENCES `adam`.`instrumento` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`tipo_medicion_procesada`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`tipo_medicion_procesada` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `descripcion` TEXT NULL ,
  `script_nombre` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`medicion_procesada`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`medicion_procesada` (
  `fecha` DATE NOT NULL ,
  `instrumento_id` INT NOT NULL ,
  `valor` DOUBLE NOT NULL ,
  `hora` TIME NULL ,
  `tipo_medicion_procesada_id` INT NOT NULL ,
  `numero_datos_usados` INT NOT NULL ,
  INDEX `fk_medicion_procesada_instrumento` (`instrumento_id` ASC) ,
  INDEX `fk_medicion_procesada_tipo_medicion_procesada` (`tipo_medicion_procesada_id` ASC) ,
  PRIMARY KEY (`fecha`, `instrumento_id`, `tipo_medicion_procesada_id`) ,
  UNIQUE INDEX `indice_clave` (`fecha` ASC, `instrumento_id` ASC, `tipo_medicion_procesada_id` ASC) ,
  CONSTRAINT `fk_medicion_procesada_instrumento`
    FOREIGN KEY (`instrumento_id` )
    REFERENCES `adam`.`instrumento` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_medicion_procesada_tipo_medicion_procesada`
    FOREIGN KEY (`tipo_medicion_procesada_id` )
    REFERENCES `adam`.`tipo_medicion_procesada` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`revision_sensor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`revision_sensor` (
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `instrumento_id` INT NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `fecha` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `estado` TINYTEXT NOT NULL ,
  INDEX `fk_revision_sensor_instrumento` (`instrumento_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_revision_sensor_instrumento`
    FOREIGN KEY (`instrumento_id` )
    REFERENCES `adam`.`instrumento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` TINYTEXT NOT NULL ,
  `nombre` TINYTEXT NOT NULL ,
  `administrador` INT NOT NULL ,
  `aviso_sensor` INT NOT NULL DEFAULT 0 ,
  `telefono_movil` TINYTEXT NULL ,
  `clave` TINYTEXT NULL ,
  `ultimo_ingreso` DATETIME NULL ,
  `rut` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;


-- -----------------------------------------------------
-- Table `adam`.`tipo_alerta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`tipo_alerta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `script` TINYTEXT NOT NULL ,
  `numero_parametros` INT NOT NULL ,
  `uso` TINYTEXT NOT NULL COMMENT '[STATION] Alerta para estaciones\n[SENSOR] Alerta para sensores' ,
  `descripcion` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`alerta_has_usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`alerta_has_usuario` (
  `alerta_id` INT NOT NULL ,
  `usuario_id` INT NOT NULL ,
  `estacion_id` INT NOT NULL ,
  `metodo_alerta` TINYTEXT NOT NULL ,
  PRIMARY KEY (`alerta_id`, `usuario_id`) ,
  INDEX `fk_alerta_has_usuario_alerta` (`alerta_id` ASC) ,
  INDEX `fk_alerta_has_usuario_usuario` (`usuario_id` ASC) ,
  INDEX `fk_alerta_has_usuario_estacion` (`estacion_id` ASC) ,
  CONSTRAINT `fk_alerta_has_usuario_alerta`
    FOREIGN KEY (`alerta_id` )
    REFERENCES `adam`.`tipo_alerta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alerta_has_usuario_usuario`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `adam`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alerta_has_usuario_estacion`
    FOREIGN KEY (`estacion_id` )
    REFERENCES `adam`.`estacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`tipo_modelo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`tipo_modelo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `descripcion` TINYTEXT NOT NULL ,
  `script_nombre` TINYTEXT NOT NULL ,
  `target` TINYTEXT NOT NULL COMMENT '[STATION]\n[SENSOR]' ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`estacion_has_modelo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`estacion_has_modelo` (
  `id_estacion` INT NOT NULL ,
  `id_tipo_modelo` INT NOT NULL ,
  `activo` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id_estacion`, `id_tipo_modelo`) ,
  INDEX `fk_estacion_has_modelo_estacion` (`id_estacion` ASC) ,
  INDEX `fk_estacion_has_modelo_tipo_modelo` (`id_tipo_modelo` ASC) ,
  CONSTRAINT `fk_estacion_has_modelo_estacion`
    FOREIGN KEY (`id_estacion` )
    REFERENCES `adam`.`estacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estacion_has_modelo_tipo_modelo`
    FOREIGN KEY (`id_tipo_modelo` )
    REFERENCES `adam`.`tipo_modelo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`modelo_procesado_estacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`modelo_procesado_estacion` (
  `fecha` DATE NOT NULL ,
  `valor` DOUBLE NOT NULL ,
  `estacion_has_modelo_id_estacion` INT NOT NULL ,
  `estacion_has_modelo_id_tipo_modelo` INT NOT NULL ,
  PRIMARY KEY (`fecha`, `estacion_has_modelo_id_estacion`, `estacion_has_modelo_id_tipo_modelo`) ,
  INDEX `fk_modelo_procesado_estacion_has_modelo` (`estacion_has_modelo_id_estacion` ASC, `estacion_has_modelo_id_tipo_modelo` ASC) ,
  CONSTRAINT `fk_modelo_procesado_estacion_has_modelo`
    FOREIGN KEY (`estacion_has_modelo_id_estacion` , `estacion_has_modelo_id_tipo_modelo` )
    REFERENCES `adam`.`estacion_has_modelo` (`id_estacion` , `id_tipo_modelo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`alerta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`alerta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fecha` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `valor1` DOUBLE NOT NULL ,
  `valor2` DOUBLE NULL DEFAULT NULL ,
  `valor3` DOUBLE NULL DEFAULT NULL ,
  `tipo_alerta_id` INT NOT NULL ,
  `estacion_id` INT NULL ,
  PRIMARY KEY (`id`, `tipo_alerta_id`) ,
  INDEX `fk_alerta_tipo_alerta` (`tipo_alerta_id` ASC) ,
  INDEX `fk_alerta_estacion` (`estacion_id` ASC) ,
  CONSTRAINT `fk_alerta_tipo_alerta`
    FOREIGN KEY (`tipo_alerta_id` )
    REFERENCES `adam`.`tipo_alerta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alerta_estacion`
    FOREIGN KEY (`estacion_id` )
    REFERENCES `adam`.`estacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`instrumento_has_modelo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`instrumento_has_modelo` (
  `instrumento_id` INT NOT NULL ,
  `tipo_modelo_id` INT NOT NULL ,
  `activo` TINYTEXT NOT NULL ,
  PRIMARY KEY (`instrumento_id`, `tipo_modelo_id`) ,
  INDEX `fk_instrumento_has_modelo_instrumento` (`instrumento_id` ASC) ,
  INDEX `fk_instrumento_has_modelo_tipo_modelo` (`tipo_modelo_id` ASC) ,
  CONSTRAINT `fk_instrumento_has_modelo_instrumento`
    FOREIGN KEY (`instrumento_id` )
    REFERENCES `adam`.`instrumento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instrumento_has_modelo_tipo_modelo`
    FOREIGN KEY (`tipo_modelo_id` )
    REFERENCES `adam`.`tipo_modelo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`modelo_procesado_instrumento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`modelo_procesado_instrumento` (
  `instrumento_has_modelo_instrumento_id` INT NOT NULL ,
  `instrumento_has_modelo_tipo_modelo_id` INT NOT NULL ,
  `fecha` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `valor` DOUBLE NOT NULL ,
  PRIMARY KEY (`instrumento_has_modelo_instrumento_id`, `instrumento_has_modelo_tipo_modelo_id`, `fecha`, `hora`) ,
  INDEX `fk_modelo_procesado_instrumento_instrumento_has_modelo` (`instrumento_has_modelo_instrumento_id` ASC, `instrumento_has_modelo_tipo_modelo_id` ASC) ,
  CONSTRAINT `fk_modelo_procesado_instrumento_instrumento_has_modelo`
    FOREIGN KEY (`instrumento_has_modelo_instrumento_id` , `instrumento_has_modelo_tipo_modelo_id` )
    REFERENCES `adam`.`instrumento_has_modelo` (`instrumento_id` , `tipo_modelo_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `adam`.`eve_permiso`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`eve_permiso` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `codigo` TINYTEXT NOT NULL ,
  `descripcion` TINYTEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;


-- -----------------------------------------------------
-- Table `adam`.`eve_parametro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`eve_parametro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` TINYTEXT NOT NULL ,
  `descripcion` TINYTEXT NOT NULL ,
  `code` TINYTEXT NOT NULL ,
  `valor` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;


-- -----------------------------------------------------
-- Table `adam`.`eve_bitacora`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`eve_bitacora` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` VARCHAR(45) NOT NULL ,
  `fecha` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `observacion` TINYTEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_adam_bitacora_usuario1` (`usuario_id` ASC) ,
  CONSTRAINT `fk_adam_bitacora_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `adam`.`usuario` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;


-- -----------------------------------------------------
-- Table `adam`.`eve_estadistica`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adam`.`eve_estadistica` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `valor` INT NULL ,
  `tipo` TINYTEXT NULL ,
  `nombre` TINYTEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_spanish_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
