<?php
/**
 * Here is your custom functions.
 */


/**
 * 展开数组.
 *
 * @param array $array
 * @param string $prefix
 * @return array
 */
if (!function_exists('ptFlattenArray')) {
    function ptFlattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, ptFlattenArray($value, $prefix . $key . '-'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }
}

/**
 * 时间美化.
 *
 * @param array $array
 * @param string $prefix
 * @return array
 */
if (!function_exists('ptTimeShowFormat')) {
    function ptTimeShowFormat(?string $time, ?int $current = null): string
    {
        if (empty($time)) {
            return '';
        }

        $time = strtotime($time);
        $current = $current ?: time();
        $diff = abs($time - $current);

        if ($diff < 60) {
            return '刚刚';
        }

        if ($diff < 3600) {
            $minutes = floor($diff / 60);
            $seconds = $diff % 60;
            return "{$minutes}分钟{$seconds}秒前";
        }

        if ($diff < 86400) {
            $hours = floor($diff / 3600);
            $minutes = floor(($diff % 3600) / 60);
            return "{$hours}小时 {$minutes}分钟前";
        }

        if ($diff < 31536000) {
            $days = floor($diff / 86400);
            $hours = floor(($diff % 86400) / 3600);
            return "{$days}天{$hours}小时前";
        }

        return date('Y-m-d H:i:s', $time);
    }
}