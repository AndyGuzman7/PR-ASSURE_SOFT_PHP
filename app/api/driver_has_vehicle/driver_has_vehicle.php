<?php

/**
 * Contains driver class/model to represent Driver table on database
 * @author Fabricio Rene Crespo Rossel
 */


/**
 * Representation of DriverHasVehicle table on database
 */
class DriverHasVehicle implements \JsonSerializable
{
    public int $id;
    public int $iddriver;
    public int $idvehicle;
    public int $status;

    public function __construct($id, $iddriver, $idvehicle, $status)
    {
        $this->id = $id;
        $this->iddriver = $iddriver;
        $this->idvehicle = $idvehicle;
        $this->status = $status;
    }

    /**
     * @return array<string, mixed> driver attributes to array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'iddriver' => $this->iddriver,
            'idvehicle' => $this->idvehicle,
            'status' => $this->status
        ];
    }
}
