<?php

namespace App\Models\Helpers;

class ValidarCPF
{

    private string $cpf;

    public function validar($cpf)
    {
        $this->cpf = $cpf;

        // Extrai somente os números
        $this->cpf = preg_replace('/[^0-9]/is', '', $this->cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($this->cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $this->cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf[$c] != $d) {
                return false;
            }
        }
        return $this->cpf;
    }
}
