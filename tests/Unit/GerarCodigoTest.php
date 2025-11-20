<?php

namespace Tests\Unit;
use App\Http\Controllers\ConfirmarSoliController;
use PHPUnit\Framework\TestCase;


// CT001 validar código aleatório unico
class GerarCodigoTest extends TestCase
{
    protected string $codAleatorio;

    //  Sempre que chama o atributo acima o método abaixo e o serviço de codigo aleatório é usado
    protected function setUp(): void
    {
        parent::setUp();
        $this->codAleatorio = ConfirmarSoliController::gerarCodigoUnico();
    }

    // Valida a quantidade de 7 cararctes do código
    public function testCountCharCodigo(): void
    {
        $this->assertSame(7, strlen($this->codAleatorio), "O código não tem 7 caracteres");
    }

    // Valida o padrão do código
    public function testPadraoCodigo(): void
    {
        // 1. Verifica se o primeiro caractere é #
        $this->assertStringStartsWith('#', $this->codAleatorio, "O código não inicia com #");

        // 2. Verifica se o após a # o codigo é alfanumérico em caixa alta 
        $this->assertMatchesRegularExpression('/^#[A-Z0-9]{6}$/', $this->codAleatorio, "Os 6 caracteres após o # não são alfanuméricos em caixa alta.");
        // $this->assertMatchesRegularExpression('/^#[A-Z0-9]{6}$/', '#hfA326', "Os 6 caracteres após o # não são alfanuméricos em caixa alta.");
    }

    // Verifica unicidade de códigos aleatórioa
    public function testUnicidadeCodigo(): void
    {
        $codigos = [];
        $quantidadeGerada = 100;

        for ($i = 0; $i < $quantidadeGerada; $i++) {
            $novoCodigo = ConfirmarSoliController::gerarCodigoUnico();
            $codigos[] = $novoCodigo;
        }

        //Remove as duplicatas e gera um novo array
        $codigosUnicos = array_unique($codigos);

        $this->assertCount($quantidadeGerada, $codigosUnicos, "Foram gerados códigos duplicados. Total de códigos gerados:
        $quantidadeGerada, Códigos únicos encontrados: " . count($codigosUnicos));
    }
}
