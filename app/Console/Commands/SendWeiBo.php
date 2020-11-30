<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/12
 * Time: 下午10:08
 */
namespace App\Console\Commands;

use App\Jobs\NewsQueue;
use Illuminate\Console\Command;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SendWeiBo extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weibo:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send weibo';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = $this->dispatch(new NewsQueue());
        echo date('Y-m-d H:i:s') . '_success_' . $this->description;

    }

}