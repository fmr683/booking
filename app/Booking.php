<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    //
    protected $table = "booking";
    public $fillable = ['pm_id','c_id','h_total','add_total','day_type','active','b_date','discount','total'];


    public static function getAllBookings($rarray) {

      return DB::table("booking")
            ->select('booking.id','booking.total','booking.day_type','booking.b_date','customers.c_name','customers.c_number', 
            DB::raw("(SELECT SUM(booking_payment.amount) FROM booking_payment WHERE id = booking.id) AS amount"), DB::raw("GROUP_CONCAT(booking_type.name ORDER BY booking_type.name ASC SEPARATOR ', ') AS name"))
            ->join('customers', 'booking.c_id', '=', 'customers.id')
            ->join('price_mapping_btype', 'booking.pm_id', '=', 'price_mapping_btype.id')
            ->join('booking_type', 'price_mapping_btype.btype_id', '=', 'booking_type.id')
            ->whereBetween('booking.b_date',array($rarray["sdate"],$rarray["edate"]))
            ->whereIn('active', $rarray["bstatus"])
            ->whereIn('booking.day_type', $rarray["dtype"])
            ->groupBy('booking.id')
            ->groupBy('booking.total')
            ->groupBy('booking.day_type')
            ->groupBy('booking.b_date')
            ->groupBy('customers.c_name')
            ->groupBy('customers.c_number')
            ->orderBy('booking.id','DESC')
            ->get();
    }

    public static function getRecentPendingOrders($rarray) {

   

      return DB::table("booking")
            ->select('booking.id','booking.total','booking.day_type','booking.b_date','customers.c_name','customers.c_number', 
            DB::raw("(SELECT SUM(booking_payment.amount) FROM booking_payment WHERE id = booking.id) AS amount"), DB::raw("GROUP_CONCAT(booking_type.name ORDER BY booking_type.name ASC SEPARATOR ', ') AS name"))
            ->join('customers', 'booking.c_id', '=', 'customers.id')
            ->join('price_mapping_btype', 'booking.pm_id', '=', 'price_mapping_btype.id')
            ->join('booking_type', 'price_mapping_btype.btype_id', '=', 'booking_type.id')
            ->whereBetween('booking.b_date',array($rarray["sdate"],$rarray["edate"]))
            ->whereIn('active', array(1,2))
            ->groupBy('booking.id')
            ->groupBy('booking.total')
            ->groupBy('booking.day_type')
            ->groupBy('booking.b_date')
            ->groupBy('customers.c_name')
            ->groupBy('customers.c_number')
            ->orderBy('booking.id','DESC')
            ->limit(10)
            ->get();
    }


    public static function checkPossibleDuplicateItem($rarray) {


      $queryp = DB::table("booking")
            ->select('booking.id')
            ->join('price_mapping', 'booking.pm_id', '=', 'price_mapping.id')
            ->join('price_mapping_btype', 'booking.pm_id', '=', 'price_mapping_btype.id')
            ->where('booking.day_type','=',$rarray["day_type"])
            ->where('booking.b_date','=',$rarray["b_date"])
            ->whereIn('active', array(1,2))
            ->whereIn('price_mapping_btype.btype_id',function ($query) use ($rarray) {
                $query->select("btype_id")
                ->from('price_mapping')
                ->join('price_mapping_btype', 'price_mapping.id', '=', 'price_mapping_btype.id')
                ->where('price_mapping.id','=',$rarray["pm_id"]);
            });


        if (!empty($rarray['bid'])) {
            $queryp->where('booking.id', '<>', $rarray['bid']);
        }

        $result= $queryp->get();

        return $result;

    }

      public static function getBookingName($rarray) {

      return DB::table("booking")
            ->select(DB::raw("GROUP_CONCAT(booking_type.name ORDER BY booking_type.name ASC SEPARATOR ' + ') AS name"))
            ->join('price_mapping_btype', 'booking.pm_id', '=', 'price_mapping_btype.id')
            ->join('booking_type', 'price_mapping_btype.btype_id', '=', 'booking_type.id')
            ->where('booking.id', $rarray["id"])
            ->groupBy('booking.id')
            ->groupBy('booking.total')
            ->groupBy('booking.day_type')
            ->groupBy('booking.b_date')
            ->orderBy('booking.id','DESC')
            ->get();
    }

}
