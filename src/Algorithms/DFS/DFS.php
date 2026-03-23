<?php

declare(strict_types=1);

namespace src\Algorithms\DFS;
class DFS
{
    // Сомнительно, но окей)
    readonly private array $matrix;

    readonly private array $start;

    readonly private array $finish;

    private int $count = 0;

    public function __construct(array $matrix)
    {
        $this->matrix = $matrix;
    }

    private function dfs(int $i, int $j): int
    {
        $matrix = &$this->matrix;
//        $left = $right = $up = $down = false;

        $matrix[$i][$j] = 0;

        if (isset($matrix[$i][$j - 1]) && $matrix[$i][$j - 1] === 1) {
            $this->dfs($i, $j - 1);
        }

        if (isset($matrix[$i][$j + 1]) && $matrix[$i][$j + 1] === 1) {
            $this->dfs($i, $j + 1);
        }

        if (isset($matrix[$i - 1][$j]) && $matrix[$i - 1][$j] === 1) {
            $this->dfs($i - 1, $j);
        }

        if (isset($matrix[$i + 1][$j]) && $matrix[$i + 1][$j] === 1) {
            $this->dfs($i + 1, $j);
        }

        if ($i === $this->finish[0] && $j === $this->finish[1]) {
            $this->count++;
        }
    }

    public function handle(array $start, array $end): int
    {
        if ($this->checkIsStartOrFinishZero($start, $end)) {
            return 0;
        }

        $this->finish = $end;

        $n = count($this->matrix);
        $m = count($this->matrix[0]);

        for ($i = $start[0]; $i < $n; $i++) {
            for ($j = $start[1]; $j < $n; $j++) {
                if (!$this->matrix[$i][$j]) {
                    continue;
                }

                return $this->dfs($i, $j);
            }
        }

        return 24;
    }

    private function checkIsStartOrFinishZero(array $start, array $end): bool
    {
        return $this->matrix[$start[0]][$start[1]] && $this->matrix[$end[0]][$end[1]];
    }
}