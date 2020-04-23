<?php

namespace App\Http\Controllers;

use App\Event;
use App\Helpers\QueryParser;
use App\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


const FIELDS_SQL = [
    "handling_time" => "ROUND(AVG(handling_time), 2)",
    "available_time" => "ROUND(AVG(available_time), 2)",
    "after_call_working_time" => "ROUND(AVG(after_call_working_time), 2)",
    "auxiliary_time" => "ROUND(AVG(auxiliary_time), 2)",
    "occupancy" => "ROUND(AVG(occupancy), 2)",
    "talk_time" => "ROUND(AVG(talk_time), 2)",
    "hold_time" => "ROUND(AVG(hold_time), 2)",
    "taken_calls" => "ROUND(SUM(taken_calls), 2)",
    "success_payrolls" => "ROUND(SUM(success_payrolls), 2)",
    "failed_payrolls" => "ROUND(SUM(failed_payrolls), 2)",
    "failed_success_payrolls" => "ROUND(AVG(failed_success_payrolls), 2)",
    "occupancy_goal" => "(SELECT goal FROM report_goals WHERE report_id = {report_id} AND start_date >= '{start_date}' AND end_date  <= '{end_date}' LIMIT 1)",
    "failed_success_payrolls_goal" => "(SELECT goal FROM report_goals WHERE report_id = {report_id} AND start_date >= '{start_date}' AND end_date  <= '{end_date}' LIMIT 1)",
    "existing_requested_equipments_goal" => "(SELECT goal FROM report_goals WHERE report_id = {report_id} AND start_date >= '{start_date}' AND end_date  <= '{end_date}' LIMIT 1)",
    "requested_equipments" => "ROUND(SUM(requested_equipments), 2)",
    "existing_equipments" => "ROUND(SUM(existing_equipments), 2)",
    "existing_requested_equipments" => "ROUND(SUM(existing_requested_equipments), 2)",
];

const OPERATOR_DICT = [
    "equal" => "= {}",
    "not_equal" => "!= {}",
    "contains" => "like '%{}%'",
    "not_contains" => "not like '%{}%'",
    "begins_with" => "like '{}%'",
    "not_begins_with" => "not like '{}%'",
    "ends_with" => "like '%{}'",
    "not_ends_with" => "not like '%{}'",
    "greater" => "> {}",
    "greater_or_equal" => ">= {}",
    "less" => "< {}'",
    "less_or_equal" => "<= {}'",
    "is_null" => "is null'",
    "is_not_null" => "is not null",
    "is_empty" => "!= ''",
    "is_not_empty" => "!= ''",
    "in" => "in ({})",
    "not_in" => "not in ({})"
];

const REPORT_FIELDS_DICT = [
    "dailyOccupancy" => [
        [
            "type" => "date",
            "key" => "date"
        ],
        [
            "type" => "double",
            "key" => "occupancy",
            "alias" => "current"
        ],
        [
            "type" => "sub_query",
            "key" => "occupancy_goal",
            "alias" => "current_goal"
        ]
    ],
    "dailyPayroll" => [
        [
            "type" => "date",
            "key" => "date"
        ],
        [
            "type" => "double",
            "key" => "failed_success_payrolls",
            "alias" => "current"
        ],
        [
            "type" => "sub_query",
            "key" => "failed_success_payrolls_goal",
            "alias" => "current_goal"
        ]
    ],
    "dailyEquipmentAudit" => [
        [
            "type" => "date",
            "key" => "date"
        ],
        [
            "type" => "double",
            "key" => "existing_requested_equipments",
            "alias" => "current"
        ],
        [
            "type" => "sub_query",
            "key" => "existing_requested_equipments_goal",
            "alias" => "current_goal"
        ]
    ]
];

const WIDGETS_FIELDS = [
    "dailyOccupancy" => [
        [
            "title" => "AVG Ocupación por Agentes",
            "query" => "SELECT " . FIELDS_SQL["occupancy"] . " as total FROM daily_occupancies WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ],
        [
            "title" => "AVG Handling Time",
            "query" => "SELECT " . FIELDS_SQL["handling_time"] . " as total FROM daily_occupancies WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ],
        [
            "title" => "Llamadas tomadas",
            "query" => "SELECT " . FIELDS_SQL["taken_calls"] . " as total FROM daily_occupancies WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "less"
        ],
        [
            "title" => "AVG ACW Time",
            "query" => "SELECT " . FIELDS_SQL["after_call_working_time"] . " as total FROM daily_occupancies WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ]
    ],
    "dailyPayroll" => [
        [
            "title" => "Nóminas satisfactorias",
            "query" => "SELECT " . FIELDS_SQL["success_payrolls"] . " as total FROM daily_payrolls WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "less"
        ],
        [
            "title" => "Nóminas fallidas",
            "query" => "SELECT " . FIELDS_SQL["failed_payrolls"] . " as total FROM daily_payrolls WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ],
        [
            "title" => "Proporción de nóminas fallidas",
            "query" => "SELECT " . FIELDS_SQL["failed_success_payrolls"] . " as total FROM daily_payrolls WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ]
    ],
    "dailyEquipmentAudit" => [
        [
            "title" => "Equipos solicitados",
            "query" => "SELECT " . FIELDS_SQL["requested_equipments"] . " as total FROM daily_audits WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "more"
        ],
        [
            "title" => "Equipos existentes",
            "query" => "SELECT " . FIELDS_SQL["existing_equipments"] . " as total FROM daily_audits WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "less"
        ],
        [
            "title" => "Proporción de equipos existentes",
            "query" => "SELECT " . FIELDS_SQL["existing_requested_equipments"] . " as total FROM daily_audits WHERE date >= '{start_date}' AND date  <= '{end_date}'",
            "negative" => "less"
        ]
    ]
];

class ReportController extends Controller
{

    public function getEvents(Request $request)
    {
        $data = $request->all();
        preg_match("/(.*)[T]/", $data['date'][0], $start_date_match);
        preg_match("/(.*)[T]/", $data['date'][1], $end_date_match);
        $start_date = $start_date_match[1];
        $end_date = $end_date_match[1];
        $report_id = Report::whereCode($data['report'])->firstOrFail()->id;
        $events = Event::with('event')->whereRaw("start_date BETWEEN '{$start_date}' AND '{$end_date}' AND id in (SELECT event_id as id FROM event_reports WHERE report_id  = {$report_id})")->get();
        return response()->json([
            "data" => $this->parseEvents($events),
            "sql" => Event::whereRaw("start_date BETWEEN '{$start_date}' AND '{$end_date}' AND id in (SELECT event_id as id FROM event_reports WHERE report_id  = {$report_id})")->toSql()
        ]);

    }

    public function getAll()
    {
        return response()->json([
            'data' => Report::all()
        ]);
    }

    public function get(Request $request, $code)
    {
        return response()->json([
            'data' => Report::whereCode($code)->firstOrFail()
        ]);
    }

    public function getWidgetsData(Request $request)
    {
        $data = $request->all();
        preg_match("/(.*)[T]/", $data['date'][0], $start_date_match);
        preg_match("/(.*)[T]/", $data['date'][1], $end_date_match);
        $data['date'][0] = $start_date_match[1];
        $data['date'][1] = $end_date_match[1];
        $widgets = [];
        if ($data['comparison']['enabled']) {
            $comparison_dates = $this->getComparisonDates($data);
        }
        foreach (WIDGETS_FIELDS[$data['report']] as $widget) {
            $widgets[] = [
                "title" => $widget['title'],
                "value" => DB::select(str_replace([
                        "{start_date}",
                        "{end_date}",
                        "{report_id}"
                    ], [
                        $data['date'][0],
                        $data['date'][1],
                    ], $widget['query']))[0]->total ?? 0,
                "comparison_value" => $data['comparison']['enabled'] ? DB::select(str_replace([
                        "{start_date}",
                        "{end_date}",
                        "{report_id}"
                    ], [
                        $comparison_dates[0],
                        $comparison_dates[1],
                    ], $widget['query']))[0]->total ?? 0 : "-",
                "negative" => $widget['negative']
            ];
        }
        return response()->json([
            "data" => $widgets
        ]);
    }

    /**
     * @param Collection|Event[] $events
     * @return array
     */
    private function parseEvents($events)
    {
        $parsed_events = [];
        foreach ($events as $event) {
//            if ($event->events->isNotEmpty()){
//                $children = $this->parseEvents($event->event);
//            }
            $parsed_events[] = [
                "key" => $event->id,
                "description" => $event->description,
                "way_it_affects" => $event->way_it_affects,
                "start_date" => $event->start_date,
                "end_date" => $event->end_date,
                "children" => null,
                "parent_event" => $event->event->description ?? null
            ];
        }
        return $parsed_events;
    }

    private function getCountQuery(QueryParser $baseQuery, $data)
    {
        $count_query = new QueryParser();
        $count_query->query['select_raw'][] = "COUNT(1) as count";
        $count_query->query['from'] = "(" . $baseQuery->toSql() . ") v";
        if ($data['filter']['enabled'] === true) {
            $count_query->query['where_raw'] = $this->parseFilter($data['filter']['values'], "_base");
        }
        return $count_query;

    }

    private function getBaseQuery($data)
    {
        $base_query = new QueryParser();
        $base_query->query['select'] = collect($data['fields'])->map(function ($field) use ($base_query) {
            if ($field['type'] === "date" || $field['type'] === "list" || $field['type'] === "string" || $field['type'] === "time") {
                $base_query->query['group_by'][] = $field['key'] . "_base";
                return $field['key'] . " as {$field['key']}_base";
            }
            return FIELDS_SQL[$field['key']] . " as {$field['key']}_base";
        })->toArray();
        $base_query->query['from'] = Report::whereCode($data['report'])->firstOrFail()->table;
        $base_query->query['where_raw'] = "date BETWEEN '{$data['date'][0]}' AND '{$data['date'][1]}'";
        return $base_query;
    }

    private function parseFilter($filter, ?string $suffix = null)
    {
        $sql = "";
        foreach ($filter['rules'] as $key => $rule) {
            if (array_key_exists('condition', $rule)) {
                $sql .= "(" . $this->parseFilter($rule, $suffix) . ") ";
            } else {
                if (is_array($rule['value'])) {
                    $value = implode(",", array_map(function ($v) {
                        return "'{$v}'";
                    }, $rule['value']));
                } else if ($rule['type'] === "date") {
                    preg_match("/(.*)[T]/", $rule['value'], $match);
                    $value = $match[1];
                }
                $operator = OPERATOR_DICT[$rule['operator']];
                $expression = str_replace("{}", $value ?? $rule['value'], $operator);
                $sql .= "{$rule['field']}{$suffix}  $expression";
            }
            if (sizeof($filter['rules']) !== $key + 1) {
                $sql .= " AND ";
            }
        }
        return $sql;
    }

    public function getComparisonDates($data)
    {
        $start_date = Carbon::createFromFormat("Y-m-d", $data['date'][0]);
        $end_date = Carbon::createFromFormat("Y-m-d", $data['date'][1]);
        if ($data['comparison']['type'] === "previousPeriod") {
            $diff = $start_date->diff($end_date);
            $comparison_start_date = Carbon::createFromFormat("Y-m-d", $data['date'][0])->sub($diff)->format('Y-m-d');
            $comparison_end_date = Carbon::createFromFormat("Y-m-d", $data['date'][1])->sub($diff)->subDay()->format('Y-m-d');
        } else if ($data['comparison']['type'] === "previousMonth") {
            $comparison_start_date = $start_date->subMonth()->format('Y-m-d');
            $comparison_end_date = $start_date->subMonth()->format('Y-m-d');
        } else {
            preg_match("/(.*)[T]/", $data['comparison']['values'][0], $comparison_start_date_match);
            $comparison_start_date = $comparison_start_date_match[1];
            preg_match("/(.*)[T]/", $data['comparison']['values'][1], $comparison_end_date_match);
            $comparison_end_date = $comparison_end_date_match[1];
        }
        return [$comparison_start_date, $comparison_end_date];
    }

    public function getData(Request $request)
    {
        $data = $request->all();
        preg_match("/(.*)[T]/", $data['date'][0], $start_date_match);
        preg_match("/(.*)[T]/", $data['date'][1], $end_date_match);
        $data['date'][0] = $start_date_match[1];
        $data['date'][1] = $end_date_match[1];
        $current_records = $this->getReportBasedRecords($data);
        if ($data['comparison']['enabled'] === true && $data['comparison']['type'] !== null) {
            $comparison_data = $data;
            $comparison_data['date'] = $this->getComparisonDates($data);
            $comparison_records = $this->getReportBasedRecords($comparison_data);
        }
        return response()->json([
            "data" => [
                "current" => $current_records['data'],
                "current_summary" => $current_records['summary_data'],
                "outer_query" => $current_records['outer_query'],
                "count" => $current_records['count'],
                "comparison" => $comparison_records['data'] ?? [],
                "comparison_summary" => $comparison_records['summary_data'] ?? []
            ]
        ]);
    }

    public function getChartData(Request $request)
    {
        $data = $request->all();
        preg_match("/(.*)[T]/", $data['date'][0], $start_date_match);
        preg_match("/(.*)[T]/", $data['date'][1], $end_date_match);
        $data['date'][0] = $start_date_match[1];
        $data['date'][1] = $end_date_match[1];
        $current_records = $this->getChartBasedRecords($data);
        $comparison_records = [];
        if ($data['comparison']['enabled'] === true && $data['comparison']['type'] !== null) {
            $comparison_data = $data;
            $comparison_data['date'] = $this->getComparisonDates($data);
            $comparison_records = $this->getChartBasedRecords($comparison_data);
        }
        $report_id = Report::whereCode($data['report'])->firstOrFail()->id;
        $records = [];
        foreach ($current_records as $key => $current_record) {
            $records[] = [
                "index" => $key + 1,
                "current_date" => $current_record->date,
                "comparison_date" => $data['comparison']['enabled'] === true ? $comparison_records[$key]->date ?? null : null,
                "current" => $current_record->current,
                "current_goal" => $current_record->current_goal,
                "comparison" => $data['comparison']['enabled'] === true ? $comparison_records[$key]->current ?? null : null,
                "comparison_goal" => $data['comparison']['enabled'] === true ? $comparison_records[$key]->current_goal ?? null : null,
                "events" => [
                    "current" => Event::whereStartDate($current_record->date)->whereRaw("id in (SELECT event_id as id FROM event_reports WHERE report_id  = {$report_id})")
                        ->get(),
                    "comparison" => $data['comparison']['enabled'] === true ? Event::whereStartDate($comparison_records[$key]->date ?? null)->whereRaw("id in (SELECT event_id as id FROM event_reports WHERE report_id  = {$report_id})")
                        ->get() : []
                ]
            ];
        }

        return response()->json([
            "data" => $records
        ]);
    }

    private function getChartBasedRecords($data)
    {
        $base_query = $this->getBaseQuery($data);
        $outer_query = new QueryParser();
        $report_id = Report::whereCode($data['report'])->firstOrFail()->id;
        $outer_query->query['select'] = collect(REPORT_FIELDS_DICT[$data['report']])->map(function ($field) use ($outer_query, $data, $report_id) {
            if ($field['type'] === "date" || $field['type'] === "list" || $field['type'] === "string" || $field['type'] === "time") {
                $outer_query->query['group_by'][] = $field['key'];
                return $field['key'] . "_base as {$field['key']}";
            } else if ($field['type'] === "sub_query") {
                return str_replace([
                        "{start_date}",
                        "{end_date}",
                        "{report_id}"
                    ], [
                        $data['date'][0],
                        $data['date'][1],
                        $report_id
                    ],
                        FIELDS_SQL[$field['key']]) . " as {$field['alias']}";
            }
            return str_replace($field['key'], $field['key'] . "_base", FIELDS_SQL[$field['key']]) . " as {$field['alias']}";
        })->toArray();
        $outer_query->query['from'] = "(" . $base_query->toSql() . ") v";
        if ($data['filter']['enabled'] === true) {
            $outer_query->query['where_raw'] = $this->parseFilter($data['filter']['values'], "_base");
        }
        $outer_query->query['order_by_raw'] = " date";
        return DB::select($outer_query->toSql());
    }

    private function getReportBasedRecords($data)
    {

        $base_query = $this->getBaseQuery($data);

        $outer_query = new QueryParser();
        $outer_query->query['select'] = collect($data['fields'])->map(function ($field) use ($outer_query) {
            if ($field['type'] === "date" || $field['type'] === "list" || $field['type'] === "string" || $field['type'] === "time") {
                $outer_query->query['group_by'][] = $field['key'];
                return $field['key'] . "_base as {$field['key']}";
            }
            return str_replace($field['key'], $field['key'] . "_base", FIELDS_SQL[$field['key']]) . " as {$field['key']}";
        })->toArray();
        $outer_query->query['from'] = "(" . $base_query->toSql() . ") v";
        if ($data['filter']['enabled'] === true) {
            $outer_query->query['where_raw'] = $this->parseFilter($data['filter']['values'], "_base");
        }
        $outer_query->query['limit'] = $data['tableSettings']['pageSize'] ?? 30;
        $outer_query->query['offset'] = (($data['tableSettings']['pageIndex'] - 1) ?? 0) * ($data['tableSettings']['pageSize'] ?? 0);
        if ($data['tableSettings']['sortField'] !== null) {
            $outer_query->query['order_by_raw'] = $data['tableSettings']['sortField'] . " " .
                ($data['tableSettings']['sortOrder'] === "ascend" ? " ASC" : " DESC");
        }


        $summary_query = new QueryParser();
        $summary_query->query['select'] = collect($data['fields'])
            ->filter(function ($field) {
                return !($field['type'] === "date" || $field['type'] === "list" || $field['type'] === "string" || $field['type'] === "time");
            })
            ->map(function ($field) use ($summary_query) {
                return str_replace($field['key'], $field['key'] . "_base", FIELDS_SQL[$field['key']]) . " as {$field['key']}";
            })->toArray();
        $summary_query->query['from'] = "(" . $base_query->toSql() . ") v";
        if ($data['filter']['enabled'] === true) {
            $summary_query->query['where_raw'] = $this->parseFilter($data['filter']['values'], "_base");
        }
        $count_query = $this->getCountQuery($base_query, $data);
        return [
            "data" => DB::select($outer_query->toSql()),
            "summary_data" => !empty($summary_query->query['select']) ? DB::select($summary_query->toSql())[0] : [],
            "count" => DB::select($count_query->toSql())[0]->count,
            "outer_query" => $outer_query->toSql(),
            "summary_query" => $summary_query->toSql(),
            "count_query" => $count_query->toSql()
        ];
    }
}
