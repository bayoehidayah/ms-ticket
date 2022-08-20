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
			->setCellValue('E1', 'Title/Summary')
			->setCellValue('F1', 'Desc')
			->setCellValue('G1', 'Service Type')
			->setCellValue('H1', 'Urgency')
			->setCellValue('I1', 'Cause')
			->setCellValue('J1', 'Resolved Description');

		$listStatus  = $this->model_incident->listStatus;
		$listService = $this->model_incident->listServiceType;
		$listUrgent = $this->model_incident->listUrgent;

		$baris = 2;
		foreach($tickets as $ticket) {
			$user = $this->model_auth->getUser($ticket->id_pengguna);
			$resolved = $this->model_incident->getDataTicketResolved($ticket->id);

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $baris, $ticket->id)
				->setCellValue('B' . $baris, $user->nama)
				->setCellValue('C' . $baris, @$listStatus[$ticket->status])
				->setCellValue('D' . $baris, $ticket->group_room)
				->setCellValue('E' . $baris, $ticket->title)
				->setCellValue('F' . $baris, $ticket->description)
				->setCellValue('G' . $baris, @$listService[$ticket->service_type])
				->setCellValue('H' . $baris, @$listUrgent[$ticket->urgent_level])
				->setCellValue('I' . $baris, @$resolved['cause'])
				->setCellValue('J' . $baris, @$resolved['resolved_ket']);

			$baris++;
		}

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Export Ticket.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
