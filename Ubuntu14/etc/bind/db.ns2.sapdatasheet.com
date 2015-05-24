$TTL 3D
@ IN SOA ns.ns2.sapdatasheet.com. hostmaster (
        2015012718    ; serial number
        8H            ; refresh
        2H            ; retry
        4W            ; expiration
        1D )          ;
;
@      A   166.63.125.80  ; IPv4 address for ns2.sapdatasheet.com
@      NS  ns
ns     A   166.63.125.80
