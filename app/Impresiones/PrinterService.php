<?php

namespace  App\Impresiones;
 use App\Models\Modulo;
 use App\Models\QueueList;
 use App\Models\Ticket;
 use App\Repository\TicketRepository;
 use Carbon\Carbon;
 use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
 use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
 use Mike42\Escpos\Printer;
 use Mike42\Escpos\EscposImage;
 use PHPQRCode\QRcode;

 class PrinterService
{
    public function __construct()
    {

    }

     protected function CNX(){
        $modulo = Modulo::first();
        if($modulo){
            $ticketera = $modulo->ticketera;
            if($ticketera){
                if ($ticketera->level === 1) {
                    return new NetworkPrintConnector($ticketera->ip_ticket, 9100);
                }else{
                    $pass = $ticketera->password_host;
                    $user = $ticketera->name_user_host;
                    $host = $ticketera->name_host;
                    $tick = $ticketera->name_ticket;
                    if (strlen($pass) == 0) {
                        return new WindowsPrintConnector("smb://".$user."@".$host."/".$tick."");
                    }else{
                        return new WindowsPrintConnector("smb://".$user.":".$pass."@".$host."/".$tick."");
                    }
                }
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    public function toPrint(QueueList $queueList, Ticket $ticket):void{
        try {
            $connet = $this->CNX();

            if($connet && $ticket && $queueList){

                $printer = new Printer($connet);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("** FONDO DE VIVIENDA POLICIAL **\n");
                $img = EscposImage::load(storage_path().'/app/logos/logo.png',false);
                $printer->bitImage($img);
                $printer->setEmphasis(true);
                $printer->feed();
                $printer->text("** TICKET **\n");
                $printer->setTextSize(2,2);
                $printer->text($ticket->serial."-".$queueList->sequence."\n");
                $printer->setTextSize(1,1);
                $printer->setEmphasis(false);
                $printer->text(Carbon::parse($queueList->created_at)->format('d-m-Y H:m:s')."\n");

                $dir = 'temp/';
                if (!file_exists($dir))
                    mkdir($dir);
                $filename = $dir . 'qr_img.png';
                $testStr =  $ticket->serial . '-' . $queueList->sequence;
                QRcode::png($testStr, $filename, 'L', 4, 2);
                $tux = EscposImage::load($dir . basename($filename), false);
                $printer->bitImage($tux);
                $printer->text("https://www.fovipol.gob.pe\n");
                $printer->cut();
                $printer->close();

            }else{
                \Log::error("Verificar que exista un módulo y una ticketera relacionada.");
            }
        }catch (\Exception $e){
            \Log::error("Error en imporimir tocket: ". $e->getMessage());
        }

    }

}
