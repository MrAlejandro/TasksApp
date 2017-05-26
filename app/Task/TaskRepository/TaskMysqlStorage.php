<?php
namespace App\Task\TaskRepository;

use App\Task\Interfaces\TaskStorageInterface;

class TaskMysqlStorage implements TaskStorageInterface
{
    const DEFAULT_PER_PAGE = 10;
    const DEFAULT_ORDER_DESC = 'priority';
    const DEFAULT_ORDER_ASC = 'status';
    const TAGS_TO_DISPLAY = 3;

    protected $db;

    public function __construct(\Workerman\MySQL\Connection $db)
    {
        $this->db = $db;
    }

    public function create(\App\Task\Interfaces\TaskInterface $task)
    {
        $data = $task->getSaveData();
        $id = 0;

        try {
            unset($data['id']);

            $id = $this->db
                ->insert('task')
                ->cols($data)
                ->query();
        } catch (\Exception $e) {
        }

        return $id;
    }

    public function update(\App\Task\Interfaces\TaskInterface $task)
    {
        $data = $task->getSaveData();
        $uuid = !empty($data['uuid']) ? $data['uuid'] : 0;
        $result = false;

        if ($uuid) {
            try {
                unset($data['id'], $data['uuid']);

                $this->db
                    ->update('task')
                    ->cols($data)
                    ->where('uuid = :uuid')
                    ->bindValues(['uuid' => $uuid])
                    ->query();

                $result = true;
            } catch (\Exception $e) {
            }
        }

        return $result;
    }

    public function saveCollection(Array $tasks)
    {

    }

    public function get($uuid = '')
    {
        $taskData = [];

        if (!empty($uuid)) {
            $taskData = $this->db
                ->select('*')
                ->from('task')
                ->where('uuid = :uuid')
                ->bindValues(['uuid' => $uuid])
                ->row();
        }

        if (!empty($taskData['tags'])) {
            $taskData['tags'] = json_decode($taskData['tags'], true);
        }

        return $taskData;
    }

    public function getCollection($page = 1, $limit = self::DEFAULT_PER_PAGE, $sort = [])
    {
        $result = [
            'tasks_data' => [],
            'pagination' => [],
        ];

        try {
            $total = $this->db->select('COUNT(*)')->from('task')->column();
            $total = !empty($total[0]) ? $total[0] : 0;

            $limit = $limit ? (int) $limit : self::DEFAULT_PER_PAGE;
            $page = $page ? (int) $page : 1;
            $offset = ($page - 1) * $limit;
            $pages = ceil($total / $limit);

            $tasksData = $this->db->select('*')
                ->from('task')
                ->offset($offset)
                ->limit($limit)
                ->orderByASC(!empty($sort['asc']) ? $sort['asc'] : [self::DEFAULT_ORDER_ASC])
                ->orderByDESC(!empty($sort['desc']) ? $sort['desc'] : [self::DEFAULT_ORDER_DESC])
                ->query();

            foreach ($tasksData as $key => $taskData) {
                $taskData['tags'] = !empty($taskData['tags']) ? json_decode($taskData['tags'], true) : [];
                $tagsQuantity = count($taskData['tags']);

                if ($tagsQuantity) {
                    array_splice($taskData['tags'], self::TAGS_TO_DISPLAY);

                    if ($tagsQuantity > self::TAGS_TO_DISPLAY) {
                        $taskData['tags']['total'] = $tagsQuantity;
                    }
                }

                $tasksData[$key]['tags'] = $taskData['tags'];
            }

            $result['tasks_data'] = $tasksData;
            $result['pagination'] = [
                'page' => $page,
                'total_items' => $total,
                'items_per_page' => $limit,
                'pages' => $pages,
                'prev_page' => $page - 1,
                'next_page' => $page + 1,
                'pagination' => $this->getPagination($pages, $page),
            ];
        } catch (\Exception $e) {
            // TODO: implement exception handling logic
        }

        return array_values($result);
    }

    public function getPagination($pages, $page)
    {
        $pages = range(1, $pages);

        if (count($pages) == 11) {
            return $pages;
        }

        $leftBound = max(1, $page - 4);
        $rightBound = min(count($pages), $page + 4);
        $offset = ($rightBound - $leftBound) + 1;

        $pagination = array_slice($pages, $leftBound-1, $offset);
        reset($pagination);
        reset($pages);

        if ($pagination[0] != $pages[0] && $pagination[0] != $pages[1]) {
            array_unshift($pagination, 1, -1);
        }

        if ($pagination[0] != $pages[0]) {
            array_unshift($pagination, 1);
        }

        if (end($pagination) != end($pages) && end($pagination) != prev($pages)) {
            array_push($pagination, 0, end($pages));
        }

        if (end($pagination) != end($pages)) {
            array_push($pagination, end($pages));
        }

        return $pagination;
    }
}
