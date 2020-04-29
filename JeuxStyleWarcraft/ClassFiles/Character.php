<?php
/**
 * Classe d'un personnage, contient les attributs et les méthodes liées à un personnage en général
 */
class Character {

    // ----------------------------------------------- ATTRIBUTS  ----------------------------------------------- \\

    /**
     * Attribut concernant le nom et donc l'archétype d'un personnage
     *
     * @var [string]
     */
    private $characterType;
    /**
     * Attribut concernant la vie d'un personnage
     *
     * @var [int]
     */
    private $health;
    /**
     * Attribut concernant la rage d'un personnage
     *
     * @var [int]
     */
    private $rage;
    /**
     * Attribut concernant le nom du bouclier / armure d'un personnage
     *
     * @var [string]
     */
    private $shieldName;
    /**
     * Attribut concernant la valeur de protection du bouclier / armure d'un personnage
     *
     * @var [int]
     */
    private $shieldValue;
    /**
     * Attribut concernant le nom de l'arme d'un personnage
     *
     * @var [string]
     */
    private $weaponName;
    /**
     * Attribut concernant la valeur d'attaque de l'arme d'un personnage
     *
     * @var [int]
     */
    private $weaponValue;

    // ----------------------------------------------- GETTERS / SETTERS  ----------------------------------------------- \\

    // Pour l'attribut characterType

    public function getCharacterType() {
        return $this->characterType;
    }

    public function setCharacterType($value) {
        $this->characterType = $value;
    }

    // Pour l'attribut health

    public function getHealth() {
        return $this->health;
    }
    public function setHealth($value) {
        $this->health = $value;
    }

    //Pour l'attribut rage

    public function getRage() {
        return $this->rage;
    }
    public function setRage($value) {
        $this->rage = $value;
    }

    // Pour l'attribut shieldName

    public function getShieldName() {
        return $this->shieldName;
    }
    public function setShieldName($value) {
        $this->shieldName = $value;
    }

    // Pour l'attribut shieldValue

    public function getShieldValue() {
        return $this->shieldValue;
    }
    public function setShieldValue($value) {
        $this->shieldValue = $value;
    }

    // Pour l'attribut weaponName

    public function getWeaponName() {
        return $this->weaponName;
    }
    public function setWeaponName($value) {
        $this->weaponName = $value;
    }

    // Pour l'attribut weaponValue

    public function getWeaponValue() {
        return $this->weaponValue;
    }
    public function setWeaponValue($value) {
        $this->weaponValue = $value;
    }

    // ----------------------------------------------- MÉTHODES  ----------------------------------------------- \\

    /**
     * Constructeur de la classe, permettant de définir une valeur pour tous les attributs sauf pour weaponValue, qui sera aléatoire pour chaque coup porté
     * et donc ne nécessite pas qu'on le définisse lors de la création.
     *
     * @param [string] $characterType
     * @param [int] $healthValue
     * @param [int] $rageValue
     * @param [string] $shieldName
     * @param [int] $shieldValue
     * @param [string] $weaponName
     */
    public function __construct($characterType, $healthValue, $rageValue, $shieldName, $shieldValue, $weaponName) {
        $this->setCharacterType($characterType);
        $this->setHealth($healthValue);
        $this->setRage($rageValue);
        $this->setShieldName($shieldName);
        $this->setShieldValue($shieldValue);
        $this->setWeaponName($weaponName);
    }

    /**
     * Méthode permettant de définir une valeur d'attaque
     * Elle permet d'initialiser le setter de weaponValue avec un paramètre qui sera un nombre aléatoire compris entre 2 valeurs,
     * ces 2 valeurs correspondent au minimum ($min) et au maximum ($max) d'attaque de l'arme du personnage.
     *
     * @param [int] $min
     * @param [int] $max
     * @return void
     */
    public function attack($min, $max) {
        $this->setWeaponValue(rand($min,$max));
    }

    /**
     * Méthode permettant la perte de vie.
     * Elle permet d'initialiser le setter de health avec un paramètre qui sera la vie actuelle - (valeur de l'attaque - valeur de l'armure / bouclier),
     * toutefois, si le paramètre $value (correspondant à la valeur du montant de l'attaque adverse) est inférieur à la valeur de l'armure / bouclier, la méthode ne fait rien
     *
     * @param [int] $value
     * @return void
     */
    public function loseHealth($value) {
        if($value > $this->getShieldValue()){
            $this->setHealth($this->getHealth() - ($value - $this->getShieldValue()));
        }
    }

    /**
     * Méthode permettant de contrôler la valeur de la rage d'un personnage.
     * Elle permet d'initialiser le setter de rage dans 2 cas différents :
     * - Si la rage est supérieure ou égale à 100, elle doit être redéfinie à 0, on initialise donc le setter de la rage avec un paramètre égal à 0,
     * - Sinon, elle doit être augmentée du montant indiqué par $value, on initialise donc le setter de la rage avec un paramètre  qui sera la rage actuelle + la valeur d'augmentation $value
     *
     * @param [int] $value
     * @return void
     */
    public function controlRage($value) {
        if($this->getRage() >= 100) {
            $this->setRage(0);
        } else {
            $this->setRage($this->getRage() + $value);
        }
    }
}