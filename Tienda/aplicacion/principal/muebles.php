<?php

$muebles = [];

// Mueble 1
$muebles[1] = new MuebleReciclado("Silla Eco", 1, new Caracteristicas([
    "ancho" => 50,
    "alto" => 90,
    "largo" => 40,
    "color" => "verde",
    "material" => "plástico reciclado"
]), "EcoFurn", "España", 2023, "01/01/2023", "31/12/2030", 45.5, 80.0);

// Mueble 2
$muebles[2] = new MuebleTradicional("Mesa Roble", 2, new Caracteristicas([
    "ancho" => 120,
    "alto" => 75,
    "largo" => 80,
    "acabado" => "barnizado",
    "estilo" => "rústico"
]), "MueblesSur", "España", 2022, "01/03/2022", "31/12/2030", 150.0, 60.0, "S02");

// Mueble 3
$muebles[3] = new MuebleReciclado("Estantería Recy", 3, new Caracteristicas([
    "ancho" => 80,
    "alto" => 180,
    "largo" => 30,
    "tipo" => "modular",
    "color" => "gris"
]), "RecyHome", "Portugal", 2024, "01/06/2024", "31/12/2035", 89.9, 70.0);

// Mueble 4
$muebles[4] = new MuebleTradicional("Cómoda Clásica", 1, new Caracteristicas([
    "ancho" => 100,
    "alto" => 90,
    "largo" => 45,
    "tiradores" => "bronce",
    "acabado" => "mate"
]), "Clásicos SL", "España", 2021, "01/02/2021", "31/12/2030", 200.0, 85.0,"awdawdawdawdaw");

// Mueble 5
$muebles[5] = new MuebleReciclado("Banco Urbano", 2, new Caracteristicas([
    "ancho" => 150,
    "alto" => 45,
    "largo" => 40,
    "uso" => "exterior",
    "resistencia" => "alta"
]), "UrbanEco", "España", 2025, "01/01/2025", "31/12/2040", 120.0, 90.0);
