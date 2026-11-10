<?php

declare(strict_types=1);

namespace Pronosticos\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Pronosticos\CalculadoraPronosticos;

/** Pruebas unitarias de la regla que decide si un error dispara una alerta. */
final class AlertasTest extends TestCase
{
    private CalculadoraPronosticos $calculadora;

    protected function setUp(): void
    {
        $this->calculadora = new CalculadoraPronosticos();
    }

    public function testAlertaCuandoElErrorSuperaElUmbral(): void
    {
        $this->assertTrue($this->calculadora->debeGenerarAlerta(12, 10));
    }

    public function testAlertaCuandoElErrorEsIgualAlUmbral(): void
    {
        $this->assertTrue($this->calculadora->debeGenerarAlerta(10, 10));
    }

    public function testNoAlertaCuandoElErrorNoAlcanzaElUmbral(): void
    {
        $this->assertFalse($this->calculadora->debeGenerarAlerta(7, 10));
    }

    public function testRechazaUnUmbralFueraDeRango(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->calculadora->debeGenerarAlerta(5, 150);
    }
}
