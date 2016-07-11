;
; BIND data file for local loopback interface
;
$TTL	604800
@	IN	SOA	ns.sapdatasheet.com. root.ns.sapdatasheet.com. (
			      2		; Serial
			 604800		; Refresh
			  86400		; Retry
			2419200		; Expire
			 604800 )	; Negative Cache TTL
;
@	IN	NS	  ns.sapdatasheet.com.    ; ns.sapdatasheet.com  is a nameserver for sapdatasheet.com
@	IN	NS    ns1.sapdatasheet.com.   ; ns1.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	NS    ns2.sapdatasheet.com.   ; ns2.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	NS    ns3.sapdatasheet.com.   ; ns3.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	NS    ns4.sapdatasheet.com.   ; ns4.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	A	  74.208.79.9             ; IPv4 address for sapdatasheet.com
@	IN	AAAA  ::1                     ; IPv6 address
ns	IN	A     74.208.79.9             ; IPv4 address for ns.sapdatasheet.com
ns1	IN	A	  74.208.79.9             ; IPv4 address for ns1.sapdatasheet.com
ns2	IN	A	  74.208.79.9             ; IPv4 address for ns2.sapdatasheet.com
ns3	IN	A	  74.208.79.9             ; IPv4 address for ns3.sapdatasheet.com
ns4	IN	A	  74.208.79.9             ; IPv4 address for ns4.sapdatasheet.com
www	IN	A	  74.208.79.9             ; IPv4 address for www.sapdatasheet.com
