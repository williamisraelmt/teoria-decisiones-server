<?php

use App\DailyAudit;
use App\DailyOccupancy;
use App\DailyPayroll;
use App\Event;
use App\EventType;
use App\Report;
use App\ReportGoal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class General extends Seeder
{

    public function createEventTypes()
    {
        $event_types = [
            [
                "description" => "Administración"
            ],
            [
                "description" => "Recursos Humanos"
            ],
            [
                "description" => "Gobierno"
            ]
        ];

        foreach ($event_types as $event_type) {
            $new_event_type = new EventType();
            $new_event_type->description = $event_type['description'];
            $new_event_type->save();
        }

    }

    public function createReports()
    {
        $reports = [
            [
                "code" => "dailyOccupancy",
                "description" => "Ocupación por día",
                "table" => "daily_occupancies"
            ],
            [
                "code" => "dailyPayroll",
                "description" => "Nómina por día",
                "table" => "daily_payrolls"
            ],
            [
                "code" => "dailyRotation",
                "description" => "Rotación por día",
                "table" => "daily_rotations"
            ],
            [
                "code" => "dailyEquipmentAudit",
                "description" => "Auditoría de equipos por día",
                "table" => "daily_audits"
            ]
        ];

        foreach ($reports as $report) {
            $new_report = new Report();
            $new_report->code = $report['code'];
            $new_report->description = $report['description'];
            $new_report->table = $report['table'];
            $new_report->save();
        }

    }

    public function createEvents()
    {

        $event_types = EventType::all()->keyBy(function ($v) {
            return $v['description'];
        });
        $reports = Report::all()->keyBy(function ($v) {
            return $v['code'];
        });

        $event_1 = new Event();
        $event_1->start_date = "2020-02-01";
        $event_1->end_date = "2020-02-01";
        $event_1->description = "Contratación de 5 empleados";
        $event_1->way_it_affects = "positive";
        $event_1->event_type_id = $event_types->get("Administración")->id;
        $event_1->save();

        $event_1->reports()->attach(
            [
                $reports->get('dailyOccupancy')->id,
                $reports->get('dailyPayroll')->id,
            ]);

        $event_2 = new Event();
        $event_2->start_date = "2020-02-10";
        $event_2->end_date = "2020-02-10";
        $event_2->description = "Aplicación de incentivos a empleados nuevos por metas";
        $event_2->way_it_affects = "positive";
        $event_2->event_id = $event_1->id;
        $event_2->event_type_id = $event_types->get("Recursos Humanos")->id;
        $event_2->save();

        $event_2->reports()->attach(
            [
                $reports->get('dailyOccupancy')->id,
                $reports->get('dailyPayroll')->id,
            ]);

        $event_3 = new Event();
        $event_3->start_date = "2020-02-13";
        $event_3->end_date = "2020-02-13";
        $event_3->description = "Contratación de nuevo empleado en nómina";
        $event_3->way_it_affects = "positive";
        $event_3->event_type_id = $event_types->get("Recursos Humanos")->id;
        $event_3->save();

        $event_3->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
            ]);

        $event_3 = new Event();
        $event_3->start_date = "2020-02-13";
        $event_3->end_date = "2020-02-13";
        $event_3->description = "Contratación de nuevo empleado en nómina";
        $event_3->way_it_affects = "negative";
        $event_3->event_type_id = $event_types->get("Recursos Humanos")->id;
        $event_3->save();

        $event_3->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
            ]);

        $event_4 = new Event();
        $event_4->start_date = "2020-02-17";
        $event_4->end_date = "2020-02-17";
        $event_4->description = "Despido de 3 empleados";
        $event_4->way_it_affects = "negative";
        $event_4->event_type_id = $event_types->get("Recursos Humanos")->id;
        $event_4->save();

        $event_4->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
            ]);

        $event_5 = new Event();
        $event_5->start_date = "2020-02-17";
        $event_5->end_date = "2020-02-17";
        $event_5->description = "Contratación de auditor interno";
        $event_5->way_it_affects = "negative";
        $event_5->event_type_id = $event_types->get("Administración")->id;
        $event_5->save();

        $event_5->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
            ]);

        // Segundo mes

        $event_6 = new Event();
        $event_6->start_date = "2020-03-02";
        $event_6->end_date = "2020-03-02";
        $event_6->description = "Anuncio de primer caso de covid-19 en el país";
        $event_6->way_it_affects = "negative";
        $event_6->event_type_id = $event_types->get("Gobierno")->id;
        $event_6->save();

        $event_6->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
            ]);

        $event_7 = new Event();
        $event_7->start_date = "2020-03-06";
        $event_7->end_date = "2020-03-06";
        $event_7->description = "Implementación de trabajo desde casa";
        $event_7->way_it_affects = "positive";
        $event_7->event_type_id = $event_types->get("Administración")->id;
        $event_7->event_id = $event_6->id;
        $event_7->save();

        $event_7->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
                $reports->get('dailyRotation')->id,
            ]);

        $event_8 = new Event();
        $event_8->start_date = "2020-03-16";
        $event_8->end_date = "2020-04-30";
        $event_8->description = "Declaración de Estado de Emergencia";
        $event_8->way_it_affects = "negative";
        $event_8->event_type_id = $event_types->get("Gobierno")->id;
        $event_8->event_id = $event_6->id;
        $event_8->save();

        $event_8->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
                $reports->get('dailyOccupancy')->id,
            ]);

        $event_9 = new Event();
        $event_9->start_date = "2020-03-17";
        $event_9->end_date = "2020-04-30";
        $event_9->description = "Incentivos por horas extra";
        $event_9->way_it_affects = "positive";
        $event_9->event_type_id = $event_types->get("Gobierno")->id;
        $event_9->event_id = $event_6->id;
        $event_9->save();

        $event_9->reports()->attach(
            [
                $reports->get('dailyPayroll')->id,
                $reports->get('dailyRotation')->id,
                $reports->get('dailyOccupancy')->id,
            ]);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_date = Carbon::createFromFormat('Y-m-d', '2020-01-01');
        $base_start_date = clone $start_date;
        $end_date = Carbon::createFromFormat('Y-m-d', '2020-04-20');

//        $this->call('migrate:fresh', ['--seed' => 'true']);

        $this->createEventTypes();
        $this->createReports();
        $this->createEvents();

        $ran_dates = 0;

        $employees = ["Nicole Nathalie Martínez Tejada", "José Herrera", "Eric Gómez ", "Mariela  Gómez", "Andrys Aragonés", "Fanny", "Yoamny ", "Williams Martínez", "Luz ", "Estela ", "Aminta ", "Marie Ann Cruz", "Natalia Betances", "Heigar Javier Pichardo", "Drian Jiménez ", "Oliver Rodriguez", "Francisca Tejada", "Yudelqui Gómez ", "Angel Villamil ", "Laura Rodríguez", "Juan Rodríguez", "Jorge Burgos", "Heriberto Quiñones ", "Lucía Tejada ", "Albert Paz", "José Luis Inoa Santana  ", "Luisa Esther Tavarez Felix ", "Milagros del rosario tejada cruz de gonzalez"];

        $projects = ["High View Travel", "DollarPhone", "Quick transfer", "Ship Allways"];

        $managers = ["Jack Ibrahim", "Anabelle Salce"];

        $parsed_supervisors = [
            [
                "Cristian Gomez",
                $projects[0],
                $managers[0]
            ],
            [
                "Juan Hiciano",
                $projects[1],
                $managers[0]
            ],
            [
                "Dulce Ramirez",
                $projects[2],
                $managers[0]
            ],
            [
                "Diana González",
                $projects[2],
                $managers[1]
            ],
            [
                "Lissette Lora",
                $projects[3],
                $managers[1]
            ],
            [
                "Rosmery Mercado",
                $projects[3],
                $managers[1]
            ],

        ];

        $schedule_times = [
            [
                "start" => "08:00:00",
                "end" => "17:00:00"
            ],
            [
                "start" => "10:00:00",
                "end" => "06:00:00"
            ],
            [
                "start" => "12:00:00",
                "end" => "08:00:00"
            ]
        ];

        $accounting_employees = ["Yeridania Quezada", "Yessica Peña"];

        $auditor_names = ["Alejandro Lazala", "Jorge Sued", "Yamilka Estevez"];

        $work_start_dates = [
            "2019-02-07",
            "2019-03-25",
            "2019-04-18",
            "2019-05-30",
            "2019-06-11",
            "2019-07-03",
            "2019-07-12",
            "2019-07-18",
            "2019-08-23",
            "2019-09-09",
            "2019-09-11",
            "2019-09-12",
            "2019-10-02",
            "2019-10-11",
            "2019-11-26",
            "2020-01-07",
            "2020-01-13",
            "2020-01-17",
            "2020-01-29",
            "2020-02-12",
            "2019-01-07",
            "2019-01-18",
            "2019-01-30",
            "2019-02-15",
            "2019-03-08",
            "2019-04-09",
            "2019-05-17",
            "2019-05-23",
            "2019-06-12",
            "2019-06-26",
            "2019-07-01",
            "2019-07-12",
            "2019-09-03",
            "2019-09-11",
            "2019-10-16",
            "2019-10-18",
            "2019-10-23",
            "2019-11-04",
            "2019-11-20",
            "2019-12-12",
            "2020-01-02",
            "2020-01-21",
            "2020-02-26",
            "2020-03-03",
            "2020-03-18",
        ];

        $parsed_employees = collect($employees)->map(function ($agent) use (
            $parsed_supervisors,
            $projects,
            $schedule_times,
            $work_start_dates
        ) {
            $schedule_time = $schedule_times[rand(0, sizeof($schedule_times) - 1)];
            $supervisor = $parsed_supervisors[rand(0, sizeof($parsed_supervisors) - 1)];
            return [
                "employee_name" => $agent,
                "supervisor_name" => $supervisor[0],
                "manager_name" => $supervisor[1],
                "project_name" => $supervisor[2],
                "schedule_start_time" => $schedule_time['start'],
                "schedule_end_time" => $schedule_time['end'],
                "work_start_date" => $work_start_dates[rand(0, sizeof($work_start_dates) - 1)]
            ];
        });

        $reports = Report::all()->keyBy(function ($v) {
            return $v['code'];
        });

        while ($ran_dates <= $base_start_date->diff($end_date)->days) {
            $parsed_employees->random(15)->each(function ($employee) use ($start_date, $reports) {
                $taken_calls = rand(120, 150);
                $after_call_working_time = rand(30, 80);
                $available_time = rand(15, 20);
                $auxiliary_time = rand(5, 10);
                $talk_time = rand(200, 240);
                $hold_time = rand(20, 80);
                $handling_time = $talk_time + $hold_time + $after_call_working_time;
                $new_agent_occupancy = new DailyOccupancy();
                $new_agent_occupancy->date = $start_date->format('Y-m-d');
                $new_agent_occupancy->employee_name = $employee['employee_name'];
                $new_agent_occupancy->supervisor_name = $employee['supervisor_name'];
                $new_agent_occupancy->manager_name = $employee['manager_name'];
                $new_agent_occupancy->project_name = $employee['project_name'];
                $new_agent_occupancy->handling_time = $handling_time;
                $new_agent_occupancy->available_time = $available_time;
                $new_agent_occupancy->taken_calls = $taken_calls;
                $new_agent_occupancy->after_call_working_time = $after_call_working_time;
                $new_agent_occupancy->talk_time =  $talk_time;
                $new_agent_occupancy->hold_time = $hold_time;
                $new_agent_occupancy->auxiliary_time = $auxiliary_time;
                $new_agent_occupancy->occupancy = $handling_time / ($available_time - $auxiliary_time);
                $new_agent_occupancy->schedule_start_time = $employee['schedule_start_time'];
                $new_agent_occupancy->schedule_end_time = $employee['schedule_end_time'];
                $new_agent_occupancy->work_start_date = $employee['work_start_date'];
                $new_agent_occupancy->work_end_date = null;
                $new_agent_occupancy->report_id = $reports->get('dailyOccupancy')->id;
                $new_agent_occupancy->save();
            });

            $report_goal = new ReportGoal();
            $report_goal->goal = rand(25, 40);
            $report_goal->start_date = $start_date->format("Y-m-d");
            $report_goal->end_date = $start_date->format("Y-m-d");
            $report_goal->report_id = $reports->get('dailyOccupancy')->id;
            $report_goal->save();

            if ($start_date->day === 12 || $start_date->day === 28){
                foreach ($accounting_employees as $accounting_employee){
                    $success = rand(200, 300);
                    $failed = rand(5, 50);
                    $daily_payroll = new DailyPayroll();
                    $daily_payroll->date = $start_date->format('Y-m-d');
                    $daily_payroll->employee_name = $accounting_employee;
                    $daily_payroll->success_payrolls = $success;
                    $daily_payroll->failed_payrolls = $failed;
                    $daily_payroll->failed_success_payrolls = $failed / $success;
                    $daily_payroll->report_id = $reports->get('dailyPayroll')->id;
                    $daily_payroll->work_start_date = $work_start_dates[rand(0, sizeof($work_start_dates) - 1)];
                    $daily_payroll->save();
                }

                $report_goal = new ReportGoal();
                $report_goal->goal = rand(25, 40);
                $report_goal->start_date = $start_date->format("Y-m-d");
                $report_goal->end_date = $start_date->format("Y-m-d");
                $report_goal->report_id = $reports->get('dailyPayroll')->id;
                $report_goal->save();
            }

            if ($start_date->isThursday() || $start_date->isTuesday()) {

                foreach ($auditor_names as $auditor_name){

                    $parsed_employees->random(3)->each(function ($employee) use ($start_date, $reports, $auditor_name) {
                        $requested = rand(3, 5);
                        $existing = rand(3, 5);
                        if ($existing > $requested) {
                            $requested = $existing;
                        }
                        $daily_equipment_audit = new DailyAudit();
                        $daily_equipment_audit->date = $start_date->format('Y-m-d');
                        $daily_equipment_audit->auditor_name = $auditor_name;
                        $daily_equipment_audit->supervisor_name = $employee['supervisor_name'];
                        $daily_equipment_audit->manager_name = $employee['manager_name'];
                        $daily_equipment_audit->project_name = $employee['project_name'];
                        $daily_equipment_audit->requested_equipments = $requested;
                        $daily_equipment_audit->existing_equipments = $existing;
                        $daily_equipment_audit->existing_requested_equipments = $existing / $requested;
                        $daily_equipment_audit->report_id = $reports->get('dailyEquipmentAudit')->id;
                        $daily_equipment_audit->save();

                    });
                }

                $report_goal = new ReportGoal();
                $report_goal->goal = rand(0.8, 0.9);
                $report_goal->start_date = $start_date->format("Y-m-d");
                $report_goal->end_date = $start_date->format("Y-m-d");
                $report_goal->report_id = $reports->get('dailyEquipmentAudit')->id;
                $report_goal->save();
            }

            $ran_dates++;
            $start_date = $start_date->addDays(1);

        }

    }
}
