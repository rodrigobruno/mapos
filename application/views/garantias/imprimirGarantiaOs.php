<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    $hoje = date('d/m/Y');
    $numeroOs = ! empty($osGarantia->idOs) ? $osGarantia->idOs : '';
    $mostraValidade = in_array($osGarantia->osStatus ?? '', ['Finalizado', 'Faturado'], true)
        && ! empty($osGarantia->osDataFinal)
        && is_numeric($osGarantia->diasGarantia ?? null)
        && (int) $osGarantia->diasGarantia > 0;
    $validade = $mostraValidade ? dateInterval($osGarantia->osDataFinal, $osGarantia->diasGarantia) : null;
    $CI = &get_instance();
    $CI->load->helper('text');
    $tituloPdf = url_title(
        convert_accented_characters('pixelfix-' . $numeroOs . '-garantia-' . ($osGarantia->nomeCliente ?? '')),
        '-',
        true
    );
    if ($tituloPdf === '') {
        $tituloPdf = 'pixelfix-garantia';
    }
    ?>
    <title><?= htmlspecialchars($tituloPdf, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/matrix-style.css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 4mm;
            margin: 1mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0.5cm;
            border: 0px red solid;
            height: 257mm;
            outline: 2cm #FFEAEA solid;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid page" id="viaCliente">
        <div class="subpage">
            <div class="row-fluid">
                <div class="span12">
                    <div class="invoice-content">
                        <div class="invoice-head" style="margin-bottom: 0">

                            <table class="table table-condensed">
                                <tbody>
                                    <?php if ($emitente == null) { ?>
                                        <tr>
                                            <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/mapos/emitente">Configurar</a>
                                                <<<</td> </tr> <?php
                                    } else { ?> <tr>
                                            <td style="width: 25%"><img src=" <?php echo $emitente->url_logo; ?> "></td>
                                            <td> <span style="font-size: 20px; ">
                                                    <?php echo $emitente->nome; ?></span> <br />
                                                <span>
                                                    <?php echo $emitente->cnpj; ?> <br />
                                                    <?php echo $emitente->rua . ', nº:' . $emitente->numero . ', ' . $emitente->bairro . ' - ' . $emitente->cidade . ' - ' . $emitente->uf; ?> </span> </br> <span> E-mail:
                                                    <?php echo $emitente->email . ' - Fone: ' . $emitente->telefone; ?>
                                                </span>
                                            </td>
                                            <td style="width: 20%; text-align: left">
                                                <br />
                                                <span>Garantia OS: <?= $numeroOs ?></span>
                                                <br />
                                                <span>Emissão: <?= $hoje ?></span>
                                                <?php if ($validade !== null) { ?>
                                                    <br />
                                                    <span>Validade: <?= $validade ?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; padding-left: 0">
                                            <ul>
                                                <li>
                                                    <span>
                                                        <h5 class="text-center">Termo de Garantia</h5>
                                                    </span>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 100%; padding-left: 0">
                                            <ul>
                                                <li>

                                                    <span><?php echo htmlspecialchars_decode($osGarantia->textoGarantia) ?></span><br />
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-condensed">
                                <tbody>
                                    <tr>
                                        <td>Data<br><strong><?= $hoje ?></strong>
                                            <hr style="margin: 0;">
                                        </td>
                                        <td>Assinatura do Técnico Responsável
                                            <br>
                                            <img src="<?php echo base_url('assets/img/assinatura-tecnico-garantia.png'); ?>"
                                                 alt="Assinatura do técnico"
                                                 style="max-height: 48px; max-width: 220px; height: auto; width: auto; margin: 4px 0;">
                                            <hr style="margin: 0;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/matrix.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>
