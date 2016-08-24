<?php 
class General {

	var $mysqli;

    function set_connection($mysqli) {
        $this->db =& $mysqli;
    }
	
	function categories($order)
	{
	$sql = "SELECT * FROM categories ORDER BY $order";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while ($row = $query->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}
	
	}
	
	function pages($order)
	{
	$sql = "SELECT * FROM pages ORDER BY $order";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while ($row = $query->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}
	
	}
	
	function sources()
	{
	$sql = "SELECT id,title FROM sources ORDER BY id ASC";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while ($row = $query->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}
	
	}
	
	function links($order)
	{
	$sql = "SELECT * FROM links ORDER BY $order";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while ($row = $query->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}
	
	}
	
	function link($id)
	{
	$sql = "SELECT * FROM links WHERE id='$id' LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}
	
	}
	
	function page($id)
	{
	$sql = "SELECT * FROM pages WHERE id='$id' LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}
	
	}
	
	function category($id)
	{
	$sql = "SELECT * FROM categories WHERE id='$id' LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}
	}
	
	
	function news($id)
	{
	$sql = "SELECT * FROM news WHERE id='$id' LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}
	}
	
	function source($id)
	{
	$sql = "SELECT * FROM sources WHERE id='$id' LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}
	}
	
	function start_period() {
	$sql = "SELECT month,year FROM news ORDER BY id ASC LIMIT 1";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}	
	}
	
	function statistics_news($day,$month,$year) {
	$sql = "SELECT day,month,year FROM news WHERE day='$day' AND month='$month' AND year='$year'";
	$query = $this->db->query($sql);
	return $query->num_rows;
	}
	
}
?>