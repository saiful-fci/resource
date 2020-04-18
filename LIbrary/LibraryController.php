<?php
namespace App\Http\Controllers;
use Validator;
use Auth;
use App\Models\Publisher;
use App\Models\member;
use App\Models\Author;
use App\Models\BookName;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;

class LibraryController extends Controller
{
	public function index()
	{
		return view('library.index');
	}
	public function loadPublisherModal()
	{
		return view('library.publisher.publisherCreate');
	}
	public function savePublisher(Request $request)
	{
		$this->validate($request,[
		    'publisher_name' => 'required',
		    'publisher_mobile' => 'required',
		]);
		$result=Publisher::create($request->all());
		if($result){
			return redirect()->back()->with('msg', 'Publisher Created Successfully!!');
		}else{
			return redirect()->back()->with('msg', 'Somthing Wrong! try again!!');
		}
	}
	public function publisherView()
	{
		$datas=Publisher::all();
		return view('library.publisher.publisherView',compact('datas'));
	}
	public function deletePublisher(Request $request)
    {
        if($request->ajax()){
            $result=DB::table('books_name')->where($request->publisherId)->get();
            if(!$result){
                $result=Publisher::find($request->publisherId)->delete();
                if($result){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 3;
            }
        }
    }
    public function updatePublisher($publisherId, Request $request)
    {
    	if($request->ajax()){
    		$result=Publisher::find($publisherId)->update($request->all());
    		if($result){
        		return 1;
        	}else{
        		return 0;
        	}
    	}
    }
    public function addMember()
    {
    	$classNames=DB::table('cc_class_name as ccn')->orderBy('view_order',"ASC")->get();
        $sessions=DB::table('academic_session')->orderBy('id',"DESC")->get();
    	return view('library.members.memberCreate',compact('classNames','sessions'));
    }
    public function getCustomIdBySarId(Request $request)
    {
    	if($request->ajax()){
    		$result=DB::table('student_academic_record')
    				->where('id',$request->sarId)
    				->get(['custom_student_id']);
    		$custom_student_id=$result[0]->custom_student_id;
    		if($custom_student_id){
                return response()->json(['data'=>$custom_student_id,'status'=>true]);
            }else{
                return response()->json(['status' => false]);
            }
    	}
    }
    public function libraryMemberSave(Request $request)
    {
    	$result=Member::where('fk_custom_student_id',$request->fk_custom_student_id)->count();
  		if($result>0){
  			return redirect()->back()->with('msg', 'Already Member');
  		}else{	
    		$result=Member::create($request->all());
    		return redirect()->back()->with('msg', 'Member Created Successfully!!');
  		}
    }
    public function viewMembers()
    {
	   $datas=DB::table('members')
    		->join('student_profile as sp','members.fk_custom_student_id','=','sp.custom_student_id')
    		->orderBy('members.id','ASC')
    		->get(['sp.custom_student_id as custom_student_id','sp.student_name_english as student_name_english','sp.present_phone_mobile as present_phone_mobile','members.id as memberId','members.fk_custom_student_id as fk_custom_student_id ','members.status']);
	   return view('library.members.libraryMemberView',compact('datas'));
    }
    public function deleteMember(Request $request)
    {
    	if($request->ajax()){
            $result=DB::table('book_borrow')->where('fk_member_id',$request->memberId)->get();
            if(!$result){
                $result=Member::find($request->memberId)->delete();
            if($result){
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);
            }
            }else{
                return response()->json(['status' => false]);
            }
    	}
    }
    public function authorAdd()
    {
        return view('library.author.authorCreate');
    }
    public function authorSave(Request $request)
    {
        $result=Author::create($request->all());
        if($result){
            return redirect()->back()->with('msg', 'Author Created Successfully!!');
        }else{
            return redirect()->back()->with('msg', 'Somthing Wrong! try again!!');
        }
    }
    public function authorView()
    {
        $datas=Author::all();
        return view('library.author.authorView',compact('datas'));
    }
    public function authorUpdate(Request $request, $authorId)
    {
        if($request->ajax()){
            $result=Author::find($authorId)->update($request->all());
            if($result){
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);
            }
        }
    }
    public function deleteauthor(Request $request)
    {
        if($request->ajax()){
            $result=DB::table('books_name')->where('fk_author_id',$request->authorId)->get();
            if(!$result){
                $result=Author::find($request->authorId)->delete();
            if($result){
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);
                }
            }
        }
    }
    public function addBook()
    {
        $publishers=Publisher::all();
        $authors=Author::all();
        return view('library.books.addBook',['publishers'=>$publishers,'authors'=>$authors]);
    }
    public function bookSave(Request $request)
    {
        // return $request->all();
        $result=BookName::create($request->all());
        if($result){
            return redirect()->back()->with('msg', 'Book Created Successfully!!');
        }else{
            return redirect()->back()->with('msg', 'Somthing Wrong! try again!!');
        }
    }
    public function bookView()
    {
        $datas=BookName::all();
        $publishers=Publisher::all();
        $authors=Author::all();
        return view('library.books.bookView',compact('datas','publishers','authors'));
    }
    public function updateBook(Request $request)
    {
        if($request->ajax()){
           $result=BookName::find($request->bookId)->update($request->all());
           if($result){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
            }
        }
    }
    public function deleteBook(Request $request)
    {
        if($request->ajax()){
            $result=DB::table('books')->where('fk_book_name_id',$request->bookId)->get();
            if(!$result)
            {
                $result=BookName::find($request->bookId)->delete();
                   if($result){
                    return response()->json(['status' => true]);
                }else{
                    return response()->json(['status' => false]);
                }
            }
        }
    }
    public function bookEntry()
    {
        $allBookNames=BookName::all();
        return view('library.books.bookEntry.bookEntry',compact('allBookNames'));
    }
    public function bookShow(Request $request)
    {
        if($request->ajax()){
            $bookName=BookName::find($request->bookId);
            $booknames=array();
            $booknames['book_id']=$bookName->id;
            $booknames['book_name']=$bookName->book_name;
            $booknames['book_price']='';
            $booknames['qty']='';
            $booknames['allAmount']='';
            Session::put("booknames.$request->bookId",$booknames);
            return response()->json(['status' => true]);
        
        }
    }
    public function bookEntryPost(Request $request)
    {
        unset($request['_token']);
        $data=$request->all();
        $book_ids=$data['book_id'];
        $book_qty=$data['qty'];
        $book_price=$data['price'];
        array_filter($book_ids);
        foreach ($book_ids as $key => $value) {
            $result=DB::table('books')
                ->insert([
                    'fk_book_name_id'=>$book_ids[$key],
                    'available_qty'=>$book_qty[$key],
                    'price'=>$book_price[$key]
                ]);       
        }
        Session::forget('booknames');
        if($result){
            return redirect()->back()->with('msg', 'Book Stored Successfully!!');
        }else{
            return redirect()->back()->with('msg', 'Somthing Wrong! try again!!');
        }        
    }
    public function deleteField(Request $request)
    {
        if($request->ajax()){
            Session::forget("booknames.$request->book_id");
            return response()->json(['status' => true]);
        }
    }
    public function updateField(Request $request)
    {
        if($request->ajax()){
            $booknames=array();
            $booknames['book_id']=$request->book_id;
            $booknames['book_name']=$request->book_name;
            $booknames['book_price']=$request->book_price;
            $booknames['qty']=$request->qty;
            $booknames['allAmount']=round($request->book_price*$request->qty,2);
            Session::put("booknames.$request->book_id",$booknames);
            return response()->json(['status' => true]);
        }
    }
    public function bookList()
    {
        $books=DB::table('books as bs')
        ->join('books_name as bn','bn.id','=','bs.fk_book_name_id')
        ->join('publishers as ps','ps.id','=','bn.fk_publisher_id')
        ->join('authors as ahs','ahs.id','=','bn.fk_author_id')
        // ->where('bs.status',1)
        // ->where('bs.available_qty','>',0)
        ->get([
            'bs.id',
            'bn.book_name',
            'bn.book_title',
            'ps.publisher_name',
            'ahs.author_name',
            'bs.available_qty',
            'bs.price',
            'bs.status'
        ]);
        return view('library.books.bookList',compact('books'));
        
    }
    public function bookAssignForm()
    {
        $bookId=Session::get("book");
        $books=DB::table('books')
           ->join('books_name','books_name.id','=','books.fk_book_name_id')
           ->whereIn('books.id',$bookId)
           ->get([
            'books.id',
            'books_name.book_name'
           ]);
        return view('library.books.bookAssign',compact('books'));
    }
    public function bookIssueForm(Request $request)
    {
        $bookIds = Session::get("book");
        $bookId = $request->bookId;
        $checkedStatus = $request->checked_status;
        if (empty($bookIds)) {
            $bookIds = ['0' => $bookId];
            Session::put("book", $bookIds);
        }
        array_push($bookIds, $bookId);
        $bookIds = Session::get('book');
        if (!in_array($bookId, $bookIds) && $checkedStatus == 1) {
            array_push($bookIds, $bookId);
            Session::put("book", $bookIds);
        } else if (in_array($bookId, $bookIds) && $checkedStatus == 0) {
            $key = array_search($bookId, $bookIds);
            unset($bookIds[$key]);
            Session::forget("book");
            Session::put("book", $bookIds);
        }
        return response()->json($bookIds);
    }
    public function choiceList()
    {
       $bookId=Session::get("book");
        $books=DB::table('books')
           ->join('books_name','books_name.id','=','books.fk_book_name_id')
           ->whereIn('books.id',$bookId)
           ->get([
            'books.id',
            'books_name.book_name'
           ]);
        return view('library.books.bookChoice',compact('books')); 
    }
    public function getMemberId(Request $request)
    {
        if($request->ajax()){
           $result=Member::where('fk_custom_student_id',$request->studentId)->first();
            if($result){     
                return response()->json(['data',$result]); 
            }else{
                return 0;
            }
        }
    }
    public function bookIssue(Request $request)
    {
        $studentId=$request->studentId;
        $memberId=$request->memberId;
        $date=$request->date;
        $data=Session::get("book");
        $bookIds=json_encode(Session::get("book"));
        $oldBorrow=DB::table('book_borrow')
                ->where('custom_student_id',$studentId)
                ->where('fk_member_id',$memberId)
                ->where('status',1)
                ->get();
        if(empty($oldBorrow)){
            $result=DB::table('members')->where('fk_custom_student_id',$studentId)->get();
            if($result){
                $result=DB::table('book_borrow')
            ->insert([
                'fk_member_id'=>$memberId,
                'custom_student_id'=>$studentId,
                'fk_books_id'=>$bookIds,
                'provide_date'=>date("Y-m-d"),
                'return_date'=>date("Y-m-d",strtotime($date)),
                'created_at'=>date("Y-m-d h:i:s"),
                'created_by'=>Auth::user()->id,
            ]);
            }else{
                return 0;
            }
        foreach ($data as $key => $value) {
            $oldQty=DB::table('books')
            ->where('id',$value)
            ->get(['available_qty as qty']);
            $result=DB::table('books')
            ->where('id',$value)
            ->update([
                'available_qty'=>$oldQty[0]->qty-1
            ]);
        }
        if($result==true){
            Session::forget('book');
           return response()->json(['status',"true"]);
        }else{
           return response()->json(['status',"false"]); 
        }

        }else{
            Session::forget('book');
          return response()->json(['return',"Please Return old Book"]);  
        }
    }
    public function itemDelete(Request $request)
    {
        if($request->ajax()){
           if($request->multiple=='multiple')
           {
            Session::forget("book");
            return response()->json(['status',"ok"]);
           }else{
            $bookId = $request->book_id;
            $bookIds = Session::get("book");
            $key = array_search($bookId, $bookIds);
            unset($bookIds[$key]);
            Session::forget("book");
            Session::put("book", $bookIds);
            return response()->json(['success' => true, 'status' => 'Queue Item Deleted SuccessFull.']);
           } 
        }
    }
    public function returnBook()
    {
        return view('library.books.returnView');
    }
    public function returnBookPost(Request $request)
    {
       if($request->ajax()){
            $borrow=DB::table('book_borrow')
            ->where('custom_student_id',$request->stdId)
            ->where('status',1)
            ->get();
            if($borrow){
                $booksIdArr=json_decode($borrow[0]->fk_books_id);
            $data=DB::table('books')
            ->join('books_name','books_name.id','=','books.fk_book_name_id')
            ->whereIn('books.id',$booksIdArr)
            ->get([
                'books_name.book_name',
                'books.id'
            ]);
                return response()->json([$data,$borrow]);
            }else{
                return 1;
            }
            
       } 
    }
    public function returnConfirm(Request $request)
    {
        $bookIdArr=$request['fk_book_names_id'];
        $updateStatus=DB::table('book_borrow')
        ->where('custom_student_id',$request['custom_id'])
        ->where('status',1)
        ->update(['status'=>0,'fine'=>$request['fine']]);
        foreach ($bookIdArr as $key => $value) {
            $oldQty=DB::table('books')
            ->where('id',$value)
            ->get(['available_qty as qty']);

            DB::table('books')
            ->where('id',$value)
            ->update([
                'available_qty'=>$oldQty[0]->qty+1
            ]);
        }
        return redirect()->back()->with('msg','Return Successfully Done!!');
        
    }
    public function activeInactive(Request $request)
    {
        if($request->ajax())
        {
            // return $request->all();
            if($request->cls=="btn btn-danger btn-xs active"){
                $result=DB::table('publishers')
                ->where('id',$request->id)
                ->update(['status'=>0]);
                if($result){    
                    return 1;
                }
            }else if($request->cls=="btn btn-danger btn-xs memberActive")
            {
              $result=DB::table('members')
                ->where('id',$request->id)
                ->update(['status'=>0]);
                if($result){    
                    return 1;
                }  
            }else if($request->cls=="btn btn-success btn-xs memberInactive")
            {
                $result=DB::table('members')
                ->where('id',$request->id)
                ->update(['status'=>1]);
                if($result){    
                    return 0;
                }
            }else if($request->cls=="btn btn-danger btn-xs authorInactive")
            {
                $result=DB::table('authors')
                ->where('id',$request->id)
                ->update(['status'=>0]);
                if($result){    
                    return 1;
                }
            }else if($request->cls=="btn btn-success btn-xs authorActive")
            {
                $result=DB::table('authors')
                ->where('id',$request->id)
                ->update(['status'=>1]);
                if($result){    
                    return 0;
                }
            }else if($request->cls=="btn btn-danger btn-xs bookInactive")
            {
                $result=DB::table('books_name')
                ->where('id',$request->id)
                ->update(['status'=>0]);
                if($result){    
                    return 1;
                }
            }else if($request->cls=="btn btn-success btn-xs bookActive")
            {
                $result=DB::table('books_name')
                ->where('id',$request->id)
                ->update(['status'=>1]);
                if($result){    
                    return 0;
                }
            }else if($request->cls=="btn btn-danger btn-xs b_listInactive")
            {
                $result=DB::table('books')
                ->where('id',$request->id)
                ->update(['status'=>0]);
                if($result){    
                    return 1;
                }
            }else if($request->cls=="btn btn-success btn-xs b_listActive")
            {
                $result=DB::table('books')
                ->where('id',$request->id)
                ->update(['status'=>1]);
                if($result){    
                    return 0;
                }
            }
            else{
                $result=DB::table('publishers')
                ->where('id',$request->id)
                ->update(['status'=>1]);
                if($result){    
                    return 0;
                }
            }
        }  
    }
    public function updateBookList(Request $request)
    {
        if($request->ajax()){
            $result=DB::table('books')
            ->where('id',$request->bookId)
            ->update([
                'price'=>$request->book_price,
                'available_qty'=>$request->book_qty
            ]);
        if($result){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
            }
        }
    }
}