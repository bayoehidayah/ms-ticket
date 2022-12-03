<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller{
	public function export(){
		$tickets     = $this->model_incident->getTicketExport();
		$spreadsheet = new Spreadsheet;
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Tracking NO')
			->setCellValue('B1', 'User Request')
			->setCellValue('C1', 'Status')
			->setCellValue('D1', 'Group/Ruangan')
			->setCellValue('E1', 'IT Support')
			->setCellValue('F1', 'Title/Summary')
			->setCellValue('G1', 'Desc')
			->setCellValue('H1', 'Service Type')
			->setCellValue('I1', 'Urgency')
			->setCellValue('J1', 'Cause')
			->setCellValue('K1', 'Resolved Description');

		$listStatus  = $this->model_incident->listStatus;
		$listService = $this->model_incident->listServiceType;
		$listUrgent = $this->model_incident->listUrgent;

		$baris = 2;
		foreach($tickets as $ticket) {
			// $user = $this->model_auth->getUser($ticket->id_pengguna);
			$resolved = $this->model_incident->getDataTicketResolved($ticket->id);
			// $it_support = $this->model_auth->getDataUser([
			// 	"id" => $ticket->id_it_support
			// ]);

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $baris, $ticket->id)
				// ->setCellValue('B' . $baris, $user->nama)
				->setCellValue('B' . $baris, $ticket->id_pengguna)
				->setCellValue('C' . $baris, @$listStatus[$ticket->status])
				->setCellValue('D' . $baris, $ticket->group_room)
				// ->setCellValue('E' . $baris, $it_support["nama"])
				->setCellValue('E' . $baris, $ticket->it_support)
				->setCellValue('F' . $baris, $ticket->title)
				->setCellValue('G' . $baris, $ticket->description)
				->setCellValue('H' . $baris, @$listService[$ticket->service_type])
				->setCellValue('I' . $baris, @$listUrgent[$ticket->urgent_level])
				->setCellValue('J' . $baris, @$resolved['cause'])
				->setCellValue('K' . $baris, @$resolved['resolved_ket']);

			$baris++;
		}

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Export Ticket.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
