<?php
/**
 * 定义的辅助函数库
 *
 * @author  xiaoyi <769076918@qq.com>"
 * @date    2018-09-21 12:06:56
 */

use Illuminate\Support\Facades\Response;
use App\Tools\Code;
use Illuminate\Http\Request;

if (! function_exists('responseJson')) {
    /**
     * responseJson 响应json数据
     *
     * @param  int   $status 状态码
     * @param  array $data   数据
     * @param  bool    $total  分页总数
     * @param string $msg    状态消息
     * @param int    $http_code
     *
     * @return mixed
     * @author xiaoyi <769076918@qq.com>
     * @date   2018-09-21 16:03:37
     */
    function responseJson(
        $status, $data = [], $total = false,
        $msg = '', $report_header = false,
        $http_code = 200)
    {
        $msg = empty($msg) ? Code::$MSG[$status] : $msg;
        $result = [
            'status' => $status,
            'msg'    => $msg,
        ];
        if ($total || $total === 0) {
            $result['data'] = [
                'total' => (int)$total,
                'list'  => $data,
            ];

            if ($report_header) {
                $result['data']['headers'] = $report_header;
            }
        } else {
            $result['data'] = $data;
        }
        // TODO(xiaoyi):渲染json无法终止掉响应
//        return Response::json($result);
       header("Content-Type:application/json");
       exit(json_encode($result));
    }
}

if (! function_exists('curl_request')) {
    function curl_request($url,$header=null, $data = null){
        //初始化curl
        $curl = curl_init();
        //设置cURL传输选项
        if(is_array($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER  , $header);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){//post方式
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        //获取采集结果
        $output = curl_exec($curl);

        //关闭cURL链接
        curl_close($curl);

        //解析json
        $json=json_decode($output,true);
        //判断json还是xml
        if ($json) {
            return $json;
        }else{
            #验证xml
            libxml_disable_entity_loader(true);
            #解析xml
            $xml = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA);
            return $xml;
        }
    }
}

if (! function_exists('get_real_user_ip')) {
    function get_real_user_ip()
    {
        $ip = '';
        if (! empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }
}

if (! function_exists('export_csv')) {
    function export_csv($data = [], $header_data = [], $file_name = 'tempory_file.csv')
    {
        $start = strripos($file_name, '/');
        $path = substr($file_name,0, $start);
        if (! is_dir($path)) {
            mkdir($path);
        }
        $fp = fopen($file_name, 'a');
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8', 'gbk//IGNORE', $value);
            }
            fputcsv($fp, $header_data);
        }
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $row =$data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'gbk//IGNORE', $value);
                }
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }
}

if (! function_exists('user')) {
    function user($key)
    {
        $user = request()->user();
        if (! empty($key)) {
            return ! empty($user[$key]) ? $user[$key] : null;
        }

        return $user;
    }
}

if (! function_exists('array_columns')) {
    /**
     * array_columns 取出数组中的多列
     *
     * @param      $input
     * @param null $column_keys
     * @param null $index_key
     *
     * @return array
     * @author xiaoyi <769076918@qq.com>
     * @date   2018-10-17 22:37:57
     * TODO(xiaoyi):后期实现支持取二维数组，及指定外键
     */
    function array_columns($input, $column_keys = null, $index_key = null)
    {
        if (is_string($column_keys) && strpos($column_keys, ',')) {
            $keys = explode(',', $column_keys);
        } elseif (is_array($column_keys)) {
            $keys = $column_keys;
        }

        $result = [];
        if (! empty($keys) && is_array($keys)) {
            foreach ($keys as $k => $v) {
                if (! empty($input[$v])) {
                    $result[] = $input[$v];
                }
            }
        }

        return $result;
    }
}

if (! function_exists('sendDingDing')) {
    function sendDingDing($to, $title, $content)
    {
        if (is_array($to)) {
            $to = implode('|', $to);
        }
        $url = 'http://notify.shanyishanmei.com/api/dingtalk/message/markdown';
        $sendContent = '# ' . $title . PHP_EOL . $content;
        $params = [
            'receiver' => $to,
            'content'  => $sendContent,
            'title'    => $title,
            'type'     => 'notify',
        ];
        $headers = ["X-TOKEN: cc584d1f411c2821eb9a459d29dfa237"];
        $param_string = http_build_query($params);
        $url .= '?' . $param_string;
        $r = curl_request($url, $headers);

        return ! empty($r) && $r['status'] === 0;
    }
}

if (! function_exists('sendEmail')) {
    function sendEmail($to, $title, $content)
    {
        $config['token'] = 'camRvhWpevZJ2dt';
        $config['server_url'] = 'http://172.20.188.97/sys/mail';
        $config['origin'] = 'marketing';

        $params = [
            'token'   => $config['token'],
            'to'      => $to,
            'origin'  => $config['origin'],
            'title'   => $title,
            'content' => $content,
        ];

        $param_string = http_build_query($params);
        // return curl_request($config['server_url'],$param_string);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['server_url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param_string);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);

        curl_close($ch);
    }
}

